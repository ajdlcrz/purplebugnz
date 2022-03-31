<?php

namespace App\Http\Controllers;

use App\Content;
use App\Partner;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

class HomeController extends Controller
{
    public function index()
    {
        $contents = Content::wherePage('homepage')->get();
        $partners = Partner::get();
        return view('welcome', compact('partners', 'contents'));
    }

    public function policy()
    {
        return view('policy');
    }

    public function terms()
    {
        return view('terms');
    }

    public function search()
    {
        return view('search_results');
    }

    public function searchList()
    {
        abort_unless(request()->wantsJson(), 404);

        $searchResults = (new Search())
            ->registerModel(\App\Content::class, function (ModelSearchAspect $modelSearchAspect) {
                $modelSearchAspect
                    ->addSearchableAttribute('section')
                    ->addSearchableAttribute('body')
                    ->addSearchableAttribute('contents')
                    ->searchable();
            })
            ->registerModel(\App\Service::class, ['title', 'description'])
            ->registerModel(\App\Subsidiary::class, ['title', 'body'])
            ->registerModel(\App\Career::class, ['title', 'overview', 'requirements'])
            ->registerModel(\App\Blog::class, ['title', 'details'])
            ->registerModel(\App\Insight::class, ['title', 'details']);

        return response([
            'count' => $searchResults->limitAspectResults(50)->search(request('keyword'))->count(),
            'results' => $searchResults->limitAspectResults(request('limit'))->search(request('keyword'))
        ], 200);
    }

    // == == == CMS SIDE == == ==
    public function editContent()
    {
        $contents = Content::wherePage('homepage')->get();
        return view('cms.pages.homepage', compact('contents'));
    }

    public function updateContent($section)
    {
        if ($section == 'banners') {
            return $this->updateHomeBanners();
        }
        if ($section == 'delete-banner') {
            return $this->deleteBanner();
        }
        if ($section == 'partners') {
            return $this->updatePartnerSsection();
        }
        if ($section == 'footer_banner') {
            return $this->updateFooterBanner();
        }
    }

    public function updateHomeBanners()
    {
        if (request('btn_label') || request('btn_link')) {
            request()->validate([
                'image' => 'nullable|mimes:jpeg,jpg,png|max:5120|dimensions:max_width=1920,max_height=873',
                'heading' => 'required|string',
                'body' => 'required',
                'btn_label' => 'required',
                'btn_link' => 'required|url',
            ]);
        } else {
            request()->validate([
                'image' => 'nullable|mimes:jpeg,jpg,png|max:5120|dimensions:max_width=1920,max_height=873',
                'heading' => 'required|string',
                'body' => 'required',
            ]);
        }


        $banners = Content::wherePage('homepage')->whereSection('banners')->first();
        $requestBanner = request()->except(['_method']);

        // check if request has image before uploading
        if (request()->hasFile('image')) {
            $fileName = Str::slug(request('heading'), '_') . '.' . request()->file('image')->getClientOriginalExtension();

            request()->file('image')->storeAs('homepage/banners/', $fileName);
            \Image::make(public_path('/storage/homepage/banners/' . '/' . $fileName))
                ->resize(1920, 873, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $requestBanner['image'] = $fileName;
        }

        if (in_array(request('id'), array_column($banners->contents, 'id'))) {
            $contents = $banners->contents; // prevents indirect modification
            $index = array_search(request('id'), array_column($contents, 'id')); // search the index of the banner

            // if file exists & new filename
            $bannerImage = $contents[$index]['image'];

            // reapply the image original value if no new image because remove front frontend logic
            if (!array_key_exists('image', $requestBanner)) {
                $requestBanner['image'] = $bannerImage;
            }

            if (Storage::exists("/homepage/banners/{$bannerImage}") && $bannerImage !== $requestBanner['image']) {
                Storage::delete("/homepage/banners/{$bannerImage}");
            }

            // updates existing banner
            $oldBanner =  $banners->contents[$index];
            $contents[$index] = $requestBanner;

            $banners->update(['contents' => $contents]);

            if ($oldBanner != $contents[$index]) {
                activity()->performedOn($banners)
                    ->tap(function (Activity $activity) use ($oldBanner, $contents, $index) {
                        $activity->properties = [
                            'old' => $oldBanner,
                            'attributes' => $contents[$index],
                        ];
                    })
                    ->log('Updated a content');
            }
        } else {
            if (!array_key_exists('image', $requestBanner)) {
                $requestBanner['image'] = "";
            }

            // append new banner
            $banners->update([
                'contents' => array_merge($banners->contents, [$requestBanner])
            ]);

            activity()->performedOn($banners)
                ->tap(function (Activity $activity) use ($requestBanner) {
                    $activity->properties = [
                        'attributes' => $requestBanner,
                    ];
                })
                ->log('Created a content');
        }

        return response()->json([
            'success' => 'Banner successfully saved.',
            'banner' => $requestBanner
        ], 200);
    }

    public function deleteBanner()
    {
        $banners = Content::wherePage('homepage')->whereSection('banners')->first();

        if (in_array(request('id'), array_column($banners->contents, 'id'))) {
            $contents = $banners->contents;
            $index = array_search(request('id'), array_column($contents, 'id'));

            if (Storage::exists("/homepage/banners/{$contents[$index]['image']}")) {
                Storage::delete("/homepage/banners/{$contents[$index]['image']}");
            }

            // removes the item from the array
            array_splice($contents, $index, 1);

            $banners->update(['contents' => $contents]);

            return response()->json(['success' => 'Banner has been removed.'], 200);
        }
    }

    public function updatePartnerSsection()
    {
        request()->validate([
            'body' => 'required'
        ]);

        $content = Content::wherePage('homepage')->whereSection('partners')->first();
        $oldContent = $content->replicate();

        $content->update([
            'body' => request('body')
        ]);

        if ($oldContent->body !== $content->body) {
            activity()->performedOn($content)
                ->tap(function (Activity $activity) use ($oldContent, $content) {
                    $activity->properties = [
                        'old' => ['body' => $oldContent->body],
                        'attributes' => ['body' => $content->body]
                    ];
                })
                ->log('Updated a content');
        }

        return response()->json(['success' => 'Body has been updated.'], 200);
    }

    public function updateFooterBanner()
    {
        request()->validate([
            'image' => 'nullable|mimes:jpeg,jpg,png|max:5120|dimensions:max_width=1920,max_height=658',
            'body' => 'required|string',
            'link' => 'required|url',
        ]);

        $footer = Content::wherePage('homepage')->whereSection('footer_banner')->first();
        $oldFooter = $footer->replicate();
        $requestFooter = request()->except(['_method']);

        if (request()->hasFile('image')) {
            $fileName = time() . request()->file('image')->getClientOriginalName();

            request()->file('image')->storeAs('homepage/footer/', $fileName);
            \Image::make(public_path("/storage/homepage/footer/{$fileName}"))
                ->resize(1920, 614, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();
        }

        $requestFooter['image'] = $fileName ?? $footer->contents['image'];

        // if file exists & new filename
        if (Storage::exists("homepage/footer{$footer->contents['image']}") && $footer->contents['image'] !== $requestFooter['image']) {
            Storage::delete("homepage/footer{$footer->contents['image']}");
        }

        $footer->update([
            'contents' => $requestFooter
        ]);

        if ($oldFooter->contents !== $footer->contents) {
            activity()->performedOn($footer)
                ->tap(function (Activity $activity) use ($oldFooter, $footer) {
                    $activity->properties = [
                        'old' => $oldFooter->contents,
                        'attributes' => $footer->contents
                    ];
                })
                ->log('Updated a content');
        }

        return response()->json([
            'success' => 'Why Purplebug has been updated.',
            'footer' => $requestFooter
        ], 200);
    }
}
