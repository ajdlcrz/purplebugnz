<?php

namespace App\Http\Controllers;

use App\Career;
use App\Content;
use App\Exports\CareersExport;
use App\Http\Resources\CareerResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class CareerController extends Controller
{
    public function careers()
    {
        $contents = Content::wherePage('careers')->get();
        return view('careers', compact('contents'));
    }

    public function career(Career $career)
    {
        return view('career', compact('career'));
    }

    public function careerForm(Career $career)
    {
        return view('career-form', compact('career'));
    }

    public function careersList()
    {
        abort_unless(request()->wantsJson(), 404);

        $query = Career::orderBy(request('column'), request('order'))
            ->where(function ($query) {
                $query->where('title', 'like', '%' . request('filter') . '%')
                    ->where('status', true);
            })
            ->orWhere(function ($query) {
                $query->where('department', 'like', '%' . request('filter') . '%')
                    ->where('status', true);
            });

        return CareerResource::collection($query->paginate(request('per_page')));
    }

    // == == == CMS SIDE == == ==
    public function index()
    {
        return view('cms.pages.spa');
    }

    public function getContents()
    {
        if (request()->ajax()) {
            return response(['contents' => Content::wherePage('careers')->get()], 200);
        }
    }

    // -- -- --  JOB MANAGEMENT -- -- --
    public function exportJobs($column, $order)
    {
        if (Career::count() > 0) {
            activity()->log('Exported Job Listings');
            return Excel::download(new CareersExport($column, $order), 'jobs.xlsx');
        }

        return back()->with(['message' => 'No Records to Export', 'status' => 'info']);
    }

    public function storeJob()
    {
        $attr =  $this->validations();

        if (request('banner')) {
            $banner = Str::slug(request('title')) . '.' . request()->file('banner')->getClientOriginalExtension();
        }

        $career = Career::create(array_merge($attr, [
            'banner' => $banner ?? null,
            'seo' => [
                'meta_title' => request('meta_title'),
                'meta_description' => request('meta_description'),
                'meta_keywords' => request('meta_keywords')
            ]
        ]));

        if (isset($banner)) {
            $path = "careers/{$career->slug}";
            // banner
            request()->file('banner')->storeAs($path, $banner);
            \Image::make(public_path("/storage/careers/{$career->slug}/$banner"))
                ->resize(1920, 614, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();
        }

        return response()->json(['success' => 'Job Successfully Created!'], 200);
    }

    public function updateJob(Career $job)
    {
        $attr =  $this->validations();

        $oldJob = $job->replicate();

        $job->update(array_merge($attr, [
            'seo' => [
                'meta_title' => request('meta_title'),
                'meta_description' => request('meta_description'),
                'meta_keywords' => request('meta_keywords')
            ]
        ]));

        // change folder name if new title
        if ($oldJob->slug != $job->slug && Storage::exists('careers/' . $oldJob->slug)) {
            Storage::move('careers/' .  $oldJob->slug, 'careers/' .  $job->slug);
        }

        if (request()->hasFile('banner')) {
            $name = uniqid($job->slug . '-');
            $banner = "{$name}." . request()->file('banner')->getClientOriginalExtension();
            $path = "careers/{$job->slug}";

            // banner
            request()->file('banner')->storeAs($path, $banner);
            \Image::make(public_path("/storage/{$path}/{$banner}"))
                ->resize(1920, 614)
                ->save();

            $job->update([
                'banner' => $banner
            ]);

            Storage::delete("{$path}/{$oldJob->banner}");
        }

        return response()->json(['success' => 'Job Updated!'], 200);
    }

    public function destroyJob(Career $job)
    {
        Storage::deleteDirectory("careers/$job->slug");
        $job->update(['banner' => null]);
        $job->delete();

        return response()->json(['success' => 'Job Has Been Deleted!'], 200);
    }

    public function jobs()
    {
        $keyword = request('filter');
        $query = Career::where('title', 'like', "%{$keyword}%")
            ->orWhere('department', 'like', "%{$keyword}%")
            ->orWhere('experience', 'like', "%{$keyword}%")
            ->orderBy(request('column'), request('order'));

        return JsonResource::collection($query->paginate(request('per_page')));
    }

    public function validations()
    {
        // converts stringified status into boolean.
        request()->merge(['status' => request('status') == 'true' ? true : false]);

        return request()->validate([
            'banner' => ['nullable', 'mimes:jpeg,jpg,png', 'max:5120', 'dimensions:max_width=1920,max_height=614'],
            'title' => 'required|string',
            'department' => 'nullable|string',
            'experience' => 'nullable|numeric',
            'status' => 'required|boolean',
            'overview' => 'required',
            'requirements' => 'required',
            'meta_title' => 'required|string',
            'meta_description' => 'required|string',
            'meta_keywords' => 'required|string'
        ]);
    }
}
