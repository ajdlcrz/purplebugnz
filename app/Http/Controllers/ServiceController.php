<?php

namespace App\Http\Controllers;

use App\Content;
use App\Service;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function services()
    {
        $contents = Content::wherePage('services')->get();
        return view('services', compact('contents'));
    }

    public function service(Service $service)
    {
        $service->load('testimonials');

        return view('service', compact('service'));
    }

    // -- -- -- CMS SIDE -- -- --
    public function index()
    {
        return view('cms.pages.spa');
    }
    public function create()
    {
        return view('cms.pages.spa');
    }
    public function edit(Service $service)
    {
        return view('cms.pages.spa');
    }

    public function getContents()
    {
        if (request()->ajax()) {
            return response(['contents' => Content::wherePage('services')->get()], 200);
        }
    }

    public function store()
    {
        $attr = request()->validate([
            'banner' => 'required|mimes:jpeg,jpg,png|max:5120|dimensions:max_width=1920,max_height=614',
            'thumbnail' => 'required|mimes:jpeg,jpg,png|max:5120',
            'title' => 'required|string|max:255|unique:services',
            'alt_text' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'facts' => 'required|string',
            'meta_title' => 'required|string',
            'meta_description' => 'required|string',
            'meta_keywords' => 'required|string',
        ]);

        if (request('banner') && request('thumbnail')) {
            $banner = Str::slug(request('alt_text'), '_') . '.' . request()->file('banner')->getClientOriginalExtension();
            $thumbnail = "thumbnail_{$banner}";
        }

        $service = Service::create(array_merge($attr, [
            'banner' => $banner ?? null,
            'offers' => json_decode(request('offers')),
            'seo' => [
                'meta_title' => request('meta_title'),
                'meta_description' => request('meta_description'),
                'meta_keywords' => request('meta_keywords')
            ]
        ]));

        if (isset($banner)) {
            $path = "services/{$service->slug}";
            // banner
            request()->file('banner')->storeAs($path, $banner);
            \Image::make(public_path("/storage/services/{$service->slug}/$banner"))
                ->resize(1920, 614, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();
            // thumbnail
            request()->file('thumbnail')->storeAs($path, $thumbnail);
            \Image::make(public_path("/storage/{$path}/{$thumbnail}"))
                ->save();
        }

        return response([
            'success' => 'Service successfully created.',
            'service' => $service
        ], 200);
    }

    public function update(Service $service)
    {
        $attr = request()->validate([
            'banner' => 'nullable|mimes:jpeg,jpg,png|max:5120|dimensions:max_width=1920,max_height=614',
            'thumbnail' => 'nullable|mimes:jpeg,jpg,png|max:5120',
            'title' => ['required', 'string', 'max:255', 'unique:services,title,' . $service->id],
            'alt_text' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'facts' => 'required|string',
            'meta_title' => 'required|string',
            'meta_description' => 'required|string',
            'meta_keywords' => 'required|string',
        ]);

        $oldService = $service->replicate();

        $service->update(array_merge($attr, [
            'offers' => json_decode(request('offers')),
            'seo' => [
                'meta_title' => request('meta_title'),
                'meta_description' => request('meta_description'),
                'meta_keywords' => request('meta_keywords')
            ]
        ]));

        // change folder name if new title
        if ($oldService->slug != $service->slug && Storage::exists('services/' . $oldService->slug)) {
            Storage::move('services/' .  $oldService->slug, 'services/' .  $service->slug);
        }

        if (request()->hasFile('banner')) {
            $banner = Str::slug($service->alt_text, '_') . '.' . request()->file('banner')->getClientOriginalExtension();
            $path = "services/{$service->slug}";

            // banner
            request()->file('banner')->storeAs($path, $banner);
            \Image::make(public_path("/storage/{$path}/{$banner}"))
                ->resize(1920, 614)
                ->save();

            $service->update([
                'banner' => $banner
            ]);
        }

        if (request()->hasFile('thumbnail')) {
            $thumbnail = "thumbnail_{$service->banner}";
            $path = "services/{$service->slug}";

            // thumbnail
            request()->file('thumbnail')->storeAs($path, $thumbnail);
            \Image::make(public_path("/storage/{$path}/{$thumbnail}"))
                ->save();
        }

        return response([
            'success' => 'Service successfully updated.',
            'service' => $service
        ], 200);
    }

    public function destroy(Service $service)
    {
        Storage::deleteDirectory("services/$service->slug");
        $service->delete();

        return response()->json(['success' => 'Service Successfully Deleted!'], 200);
    }

    public function editService(Service $service)
    {
        if (request()->wantsJson()) {
            return response([
                'service' => $service->load('testimonials'),
            ], 200);
        }
    }

    public function records()
    {
        $query = Service::paginate(request('per_page'));

        return JsonResource::collection($query);
    }

    public function updateFacts(Service $service)
    {
        $attr = request()->validate([
            'facts' => 'required'
        ]);

        $service->update($attr);

        return response()->json(['success' => 'Field updated!'], 200);
    }

    public function updateOffers(Service $service)
    {
        request()->validate([
            'heading' => 'required|string',
            'body' => 'required|string',
        ]);

        $requestDetails = request()->except(['errors']);

        if (in_array(request('id'), array_column($service->offers, 'id'))) {
            $offers = $service->offers; // prevents indirect modification
            $index = array_search(request('id'), array_column($offers, 'id')); // search the index of the contact

            // updates existing contact
            $offers[$index] = $requestDetails;

            $service->update(['offers' => $offers]);
        } else {
            // append new contact
            $service->update([
                'offers' => array_merge($service->offers, [$requestDetails])
            ]);
        }

        return response()->json([
            'success' => 'Offer details successfully saved.',
        ], 200);
    }

    public function deleteOffer(Service $service, $offer)
    {
        if (in_array($offer, array_column($service->offers, 'id'))) {
            $offers = $service->offers;
            $index = array_search($offer, array_column($offers, 'id'));

            // removes the item from the array
            array_splice($offers, $index, 1);

            $service->update(['offers' => $offers]);

            return response()->json(['success' => 'Offer has been removed.'], 200);
        }
    }
}
