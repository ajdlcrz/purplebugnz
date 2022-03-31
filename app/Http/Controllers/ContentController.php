<?php

namespace App\Http\Controllers;

use App\Content;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Contracts\Activity;

class ContentController extends Controller
{
    public function updateBanner($page)
    {
        request()->validate([
            'image' => 'nullable|mimes:jpeg,jpg,png|max:5120|dimensions:max_width=1920,max_height=614',
            'heading' => 'required|string',
            'body' => 'required',
        ]);

        $banner = Content::wherePage($page)->whereSection('banner')->first();
        $requestBanner = request()->except(['_method']);

        if (request()->hasFile('image')) {
            $fileName = "{$page}_" . request()->file('image')->getClientOriginalName();

            request()->file('image')->storeAs('banners/', $fileName);
            \Image::make(public_path("/storage/banners/{$fileName}"))
                ->resize(1920, 614, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();
        }

        $requestBanner['image'] = $fileName ?? $banner->contents['image'];

        if (Storage::exists("/banners/{$banner->contents['image']}") && $banner->contents['image'] !== $requestBanner['image']) {
            Storage::delete("/banners/{$banner->contents['image']}");
        }

        $oldBanner = $banner->replicate();

        $banner->update([
            'contents' => $requestBanner
        ]);

        if ($oldBanner->contents != $banner->contents) {
            activity()->performedOn($banner)
                ->tap(function (Activity $activity) use ($oldBanner, $banner) {
                    $activity->properties = [
                        'old' => $oldBanner->contents,
                        'attributes' => $banner->contents
                    ];
                })
                ->log('Updated a content');
        }

        return response()->json([
            'success' => 'Banner has been updated.',
            'banner' => $requestBanner
        ], 200);
    }

    public function updateSeo($page)
    {
        $attr = request()->validate([
            'meta_title' => 'required',
            'meta_description' => 'required',
            'meta_keyword' => 'required',
        ]);

        $seo = Content::wherePage($page)->whereSection('seo')->first();

        $oldSeo = $seo->replicate();
        $seo->update([
            'contents' => $attr
        ]);

        if ($oldSeo->contents != $seo->contents) {
            activity()->performedOn($seo)
                ->tap(function (Activity $activity) use ($oldSeo, $seo) {
                    $activity->properties = [
                        'old' => $oldSeo->contents,
                        'attributes' => $seo->contents
                    ];
                })
                ->log('Updated a content');
        }

        return response()->json(['success' => 'SEO has been updated.'], 200);
    }
}
