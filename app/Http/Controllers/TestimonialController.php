<?php

namespace App\Http\Controllers;

use App\Service;
use App\Testimonial;
use Illuminate\Support\Str;
use Storage;

class TestimonialController extends Controller
{
    public function store(Service $service)
    {
        if (request()->has('withValidation')) {
            request()->validate([
                'image' => 'required|mimes:jpeg,jpg,png|max:2048|dimensions:max_width=631,max_height=688',
                'name' => 'required|string|max:255',
                'position' =>  'required|string|max:255',
                'body' =>  'required',
            ]);
        }

        $imageName = uniqid() . Str::slug(request('name'), '_') . '.' . request()->file('image')->getClientOriginalExtension();

        $testimonial = $service->testimonials()->create([
            'image' => $imageName ?? null,
            'name' => request('name'),
            'position' => request('position'),
            'body' => request('body'),
        ]);

        $path = "services/{$service->slug}/testimonials";
        request()->file('image')->storeAs($path, $imageName);
        \Image::make(public_path("/storage/{$path}/{$imageName}"))
            ->resize(631, 688)
            ->save();

        return response([
            'success' => '',
            'testimonial' => collect($testimonial)->put('originalData', $testimonial)
        ], 200);
    }

    public function update(Service $service, Testimonial $testimonial)
    {
        if (request()->has('withValidation')) {
            request()->validate([
                'image' => 'nullable|mimes:jpeg,jpg,png|max:2048|dimensions:max_width=631,max_height=688',
                'name' => 'required|string|max:255',
                'position' =>  'required|string|max:255',
                'body' =>  'required',
            ]);
        }

        $path = "services/{$service->slug}/testimonials";

        if (request()->hasFile('image')) {
            $imageName = uniqid() . Str::slug(request('name'), '_') . '.' . request()->file('image')->getClientOriginalExtension();

            request()->file('image')->storeAs($path, $imageName);
            \Image::make(public_path("/storage/{$path}/{$imageName}"))
                ->resize(631, 688)
                ->save();
        }

        $imageName = $imageName ?? $testimonial->image;

        if (Storage::exists("{$path}/{$testimonial->image}") && $testimonial->image !== $imageName) {
            Storage::delete("{$path}/{$testimonial->image}");
        }

        $testimonial->update([
            'image' => $imageName,
            'name' => request('name'),
            'position' => request('position'),
            'body' => request('body'),
        ]);

        return response()->json([
            'success' => '',
            'testimonial' => collect($testimonial)->put('originalData', $testimonial)
        ], 200);
    }

    public function destroy(Service $service, Testimonial $testimonial)
    {
        $path = "services/{$service->slug}/testimonials";

        if (Storage::exists("{$path}/{$testimonial->image}")) {
            Storage::delete("$path/{$testimonial->image}");
        }
        $testimonial->delete();

        return response()->json(['success' => 'Testimonial has been deleted!'], 200);
    }
}
