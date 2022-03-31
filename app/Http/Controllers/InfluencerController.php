<?php

namespace App\Http\Controllers;

use App\Exports\InfluencersExport;
use App\Influencer;
use Illuminate\Http\Resources\Json\JsonResource;
use Maatwebsite\Excel\Facades\Excel;

class InfluencerController extends Controller
{
    // == == == CMS SIDE == == ==
    public function index()
    {
        return view('cms.pages.spa');
    }

    public function records()
    {
        $query = Influencer::where(function ($query) {
            $keyword = request('filter');

            $query->where('name', 'like', "%{$keyword}%")
                ->orWhere('email', 'like', "%{$keyword}%")
                ->orWhere('contact_number', 'like', "%{$keyword}%")
                ->orWhere('age', 'like', "%{$keyword}%")
                ->orWhere('sex', 'like', "%{$keyword}%")
                ->orWhere('total_followers', 'like', "%{$keyword}%")
                ->orWhere('content_category', 'like', "%{$keyword}%")
                ->orWhere('created_at', 'like', "%{$keyword}%");
        })
            ->orderBy(request('column'), request('order'));

        return JsonResource::collection($query->paginate(request('per_page')));
    }

    public function export($column, $order)
    {
        if (Influencer::count() > 0) {
            activity()->log('Exported Influencers');
            return Excel::download(new InfluencersExport($column, $order), 'influencers.xlsx');
        }

        return back()->with(['message' => 'No Records to Export', 'status' => 'info']);
    }
}
