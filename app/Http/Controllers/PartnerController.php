<?php

namespace App\Http\Controllers;

use App\Partner;
use Illuminate\Support\Str;
use Storage;

class PartnerController extends Controller
{
    public function store()
    {
        request()->validate([
            'image' => 'required|mimes:jpeg,jpg,png|max:2048|dimensions:max_width=197,max_height=123',
            'alt_text' => 'required|string|max:255',
            'link' => 'required|max:255|url',
        ]);

        if (request()->hasFile('image')) {
            $fileName = uniqid() . Str::slug(request('alt_text'), '_') . '.' . request()->file('image')->getClientOriginalExtension();

            request()->file('image')->storeAs('homepage/partners/', $fileName);
            \Image::make(public_path("/storage/homepage/partners/{$fileName}"))
                ->resize(197, 123, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();
        }

        $partner = Partner::create([
            'image' => $fileName ?? null,
            'alt_text' => request('alt_text'),
            'link' => request('link'),
        ]);

        return response()->json([
            'success' => 'Partner successfully saved.',
            'partner' => collect($partner)->put('originalData', $partner)
        ], 200);
    }

    public function update(Partner $partner)
    {
        request()->validate([
            'image' => 'nullable|mimes:jpeg,jpg,png|max:2048|dimensions:max_width=197,max_height=123',
            'alt_text' => 'required|string|max:255',
            'link' => 'required|max:255|url',
        ]);

        if (request()->hasFile('image')) {
            $fileName = uniqid() . Str::slug(request('alt_text'), '_') . '.' . request()->file('image')->getClientOriginalExtension();

            request()->file('image')->storeAs('homepage/partners/', $fileName);
            \Image::make(public_path("/storage/homepage/partners/{$fileName}"))
                ->resize(197, 123, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();
        }

        $imageName = $fileName ?? $partner->image;

        if (Storage::exists("homepage/partners/{$partner->image}") && $partner->image !== $imageName) {
            Storage::delete("homepage/partners/{$partner->image}");
        }

        $partner->update([
            'image' => $imageName,
            'alt_text' => request('alt_text'),
            'link' => request('link'),
        ]);

        return response()->json([
            'success' => 'Partner successfully saved.',
            'partner' => collect($partner)->put('originalData', $partner)
        ], 200);
    }

    public function destroy(Partner $partner)
    {
        if (Storage::exists("homepage/partners/{$partner->image}")) {
            Storage::delete("homepage/partners/{$partner->image}");
        }
        $partner->delete();

        return response()->json(['success' => 'Partner has been deleted!'], 200);
    }

    public function records()
    {
        return response(['partners' => Partner::get()], 200);
    }
}
