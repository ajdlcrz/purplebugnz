<?php

namespace App\Http\Controllers;

use App\Subsidiary;
use Illuminate\Support\Str;
use Storage;

class SubsidiaryController extends Controller
{
    public function store()
    {
        request()->validate([
            'image' => 'required|mimes:jpeg,jpg,png|max:2048|dimensions:max_width=170,max_height=170',
            'alt_text' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'link' => 'required|max:255|url',
            'body' => 'required|string',
        ]);

        if (request()->hasFile('image')) {
            $fileName = uniqid() . Str::slug(request('alt_text'), '_') . '.' . request()->file('image')->getClientOriginalExtension();

            request()->file('image')->storeAs('about/subsidiaries/', $fileName);
            \Image::make(public_path("/storage/about/subsidiaries/{$fileName}"))
                ->resize(170, 170, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();
        }

        $subsidiary = Subsidiary::create([
            'image' => $fileName ?? null,
            'alt_text' => request('alt_text'),
            'title' => request('title'),
            'link' => request('link'),
            'body' => request('body'),
        ]);

        return response()->json([
            'success' => 'Subsidiary successfully saved.',
            'subsidiary' => collect($subsidiary)->put('originalData', $subsidiary)
        ], 200);
    }

    public function update(Subsidiary $subsidiary)
    {
        $attr = request()->validate([
            'image' => 'nullable|mimes:jpeg,jpg,png|max:2048|dimensions:max_width=170,max_height=170',
            'alt_text' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'link' => 'required|max:255|url',
            'body' => 'required|string',
        ]);

        if (request()->hasFile('image')) {
            $fileName = uniqid() . Str::slug(request('alt_text'), '_') . '.' . request()->file('image')->getClientOriginalExtension();

            request()->file('image')->storeAs('about/subsidiaries/', $fileName);
            \Image::make(public_path("/storage/about/subsidiaries/{$fileName}"))
                ->resize(170, 170, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();
        }

        $imageName = $fileName ?? $subsidiary->image;

        if (Storage::exists("about/subsidiaries/{$subsidiary->image}") && $subsidiary->image !== $imageName) {
            Storage::delete("about/subsidiaries/{$subsidiary->image}");
        }

        $subsidiary->update(array_merge($attr, [
            'image' => $imageName,
        ]));

        return response()->json([
            'success' => 'Subsidiary successfully saved.',
            'subsidiary' => collect($subsidiary)->put('originalData', $subsidiary)
        ], 200);
    }

    public function destroy(Subsidiary $subsidiary)
    {
        if (Storage::exists("about/subsidiaries/{$subsidiary->image}")) {
            Storage::delete("about/subsidiaries/{$subsidiary->image}");
        }
        $subsidiary->delete();

        return response()->json(['success' => 'Subsidiary has been deleted!'], 200);
    }

    public function records()
    {
        return response(['subsidiaries' => Subsidiary::get()], 200);
    }
}
