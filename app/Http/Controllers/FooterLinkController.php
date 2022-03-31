<?php

namespace App\Http\Controllers;

use App\FooterLink;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Hash;

class FooterLinkController extends Controller
{
    public function index()
    {
        return view('cms.pages.footer_links');
    }

    public function store()
    {
        $attr = request()->validate([
            'title' => 'required|max:255',
            'url' => 'required|url',
        ]);

        FooterLink::create($attr);

        return response()->json(['success' => 'Footer link Successfully Created!'], 200);
    }

    public function update(FooterLink $footer_link)
    {
        $attr = request()->validate([
            'title' => 'required|max:255',
            'url' => 'required|url',
        ]);

        $footer_link->update($attr);

        return response()->json(['success' => 'Footer link Successfully Updated!'], 200);
    }

    public function destroy(FooterLink $footer_link)
    {
        $footer_link->delete();

        return response()->json(['success' => 'Footer link Successfully Deleted!'], 200);
    }

    public function records()
    {
        return JsonResource::collection(FooterLink::paginate(request('per_page')));
    }
}
