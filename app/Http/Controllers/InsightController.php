<?php

namespace App\Http\Controllers;

use App\Insight;
use App\Insight_Inquiry;
use Illuminate\Http\Request;
use App\Content;
use App\Exports\InsightsExport;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Resources\InsightResource;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class InsightController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cms.pages.spa');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cms.pages.spa');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attr = request()->validate([
            'banner' => 'required|mimes:jpeg,jpg,png|max:5120|dimensions:max_width=1920,max_height=614',
            'title' => 'required|string|max:255|unique:insights',
            'date' => 'required|date',
            'details' => 'required|string',
            'alt_text' => 'required|string|max:255',
            'meta_title' => 'required|string',
            'meta_description' => 'required|string',
            'meta_keywords' => 'required|string'
        ]);
        $banner = Str::slug(request('alt_text'), '-') . '.' . request()->file('banner')->getClientOriginalExtension();
        $insight = new Insight;
        $insight->create(array_merge($attr, [
            'banner' => $banner,
            'published_at' => request('date'),
            'seo' => [
                'meta_title' => request('meta_title'),
                'meta_description' => request('meta_description'),
                'meta_keywords' => request('meta_keywords')
            ]
        ]));


        $path = "insights/" . Str::slug($request->title);
        // banner
        request()->file('banner')->storeAs($path, $banner);
        \Image::make(public_path("/storage/{$path}/{$banner}"))
            ->resize(1920, 614)
            ->save();
        // thumbnail
        \Image::make(public_path("/storage/{$path}/{$banner}"))
            ->resize(340, 220, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->save(public_path("/storage/{$path}/thumbnail_{$banner}"));

        return response(['success' => 'Insight successfully created.'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Insight  $insight
     * @return \Illuminate\Http\Response
     */
    public function show(Insight $insight)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Insight  $insight
     * @return \Illuminate\Http\Response
     */
    public function edit(Insight $insight)
    {
        return view('cms.pages.spa');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Insight  $insight
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Insight $insight)
    {
        $attr = request()->validate([
            'banner' => 'nullable|mimes:jpeg,jpg,png|max:5120|dimensions:max_width=1920,max_height=614',
            'title' => ['required', 'string', 'max:255', 'unique:insights,title,' . $insight->id],
            'date' => 'required|date',
            'details' => 'required|string',
            'alt_text' => 'required|string|max:255',
            'meta_title' => 'required|string',
            'meta_description' => 'required|string',
            'meta_keywords' => 'required|string'
        ]);

        $oldInsight = $insight->replicate();

        $insight->update(array_merge($attr, [
            'published_at' => request('date'),
            'seo' => [
                'meta_title' => request('meta_title'),
                'meta_description' => request('meta_description'),
                'meta_keywords' => request('meta_keywords')
            ]
        ]));

        // change folder name if new title
        if ($oldInsight->slug != $insight->slug && Storage::exists('insights/' . $oldInsight->slug)) {
            Storage::move('insights/' .  $oldInsight->slug, 'insights/' .  $insight->slug);
        }

        if (request()->hasFile('banner')) {
            $banner = Str::slug($insight->alt_text, '-') . '.' . request()->file('banner')->getClientOriginalExtension();
            $path = "insights/{$insight->slug}";

            // banner
            request()->file('banner')->storeAs($path, $banner);
            \Image::make(public_path("/storage/{$path}/{$banner}"))
                ->resize(1920, 614, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();
            // thumbnail
            \Image::make(public_path("/storage/{$path}/{$banner}"))
                ->resize(340, 220, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save(public_path("/storage/{$path}/thumbnail_{$banner}"));

            $insight->update([
                'banner' => $banner
            ]);
        }

        return response([
            'success' => 'Insight successfully updated.',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Insight  $insight
     * @return \Illuminate\Http\Response
     */
    public function destroy(Insight $insight)
    {
        Storage::deleteDirectory("insights/$insight->slug");
        $insight->delete();

        return response()->json(['success' => 'Insight Successfully Deleted!'], 200);
    }
    public function records()
    {
        return JsonResource::collection(Insight::paginate(request('per_page')));
    }
    public function getContents()
    {
        if (request()->ajax()) {
            return response(['contents' => Content::wherePage('insights')->get()], 200);
        }
    }
    public function editInsight(Insight $insight)
    {
        if (request()->wantsJson()) {
            return response([
                'insight' => $insight
            ], 200);
        }
    }
    public function insights()
    {
        $contents = Content::wherePage('insights')->get();
        $latest = Insight::latest('updated_at')->first();

        return view('insights', compact('contents', 'latest'));
    }
    public function insightslist()
    {
        abort_unless(request()->wantsJson(), 404);

        $query = Insight::latest('updated_at')
            ->when(request('pageName') == 'landing', function ($query) {
                $query->where('id', '!=', Insight::latest('updated_at')->first()->id);
            })
            ->when(request('pageName') == 'innerInsight', function ($query) {
                $query->where('slug', '!=', request('insightSlug'));
            });

        return InsightResource::collection($query->paginate(4));
    }
    public function insight(Insight $insight)
    {
        $similar = Insight::where('id', '!=', $insight->id)
            ->inRandomOrder()
            ->take(2)
            ->get();

        return view('insight', compact('insight', 'similar'));
    }
    public function getInsightRecord()
    {
        $keyword = request('filter');
        $query = Insight_Inquiry::where('title', 'like', "%{$keyword}%")
            ->orWhere('name', 'like', "%{$keyword}%")
            ->orWhere('email', 'like', "%{$keyword}%")
            ->orWhere('company', 'like', "%{$keyword}%")
            ->orWhere('created_at', 'like', "%{$keyword}%")
            ->orderBy(request('column'), request('order'));

        return JsonResource::collection($query->paginate(request('per_page')));
    }
    public function exportToExcel($column, $order)
    {
        if (Insight_Inquiry::count() > 0) {
            activity()->log('Exported Insight Listings');
            $date = Carbon::now()->toDateTimeString();
            return Excel::download(new InsightsExport($column, $order), 'Insight Inquiry - ' . $date . '.xlsx');
        }

        return back()->with(['message' => 'No Records to Export', 'status' => 'info']);
    }
}
