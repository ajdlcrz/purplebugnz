<?php

namespace App\Http\Controllers;

use App\Content;
use App\Subsidiary;
use Spatie\Activitylog\Contracts\Activity;

class AboutController extends Controller
{
    public function about()
    {
        $contents = Content::wherePage('about')->get();
        $subsidiaries = Subsidiary::get();
        return view('about', compact('subsidiaries', 'contents'));
    }

    // -- -- -- CMS SIDE -- -- --
    public function editContent()
    {
        return view('cms.pages.about');
    }

    public function getContents()
    {
        if (request()->ajax()) {
            return response(['contents' => Content::wherePage('about')->get()], 200);
        }
    }

    public function updateContent($section)
    {
        if ($section == 'why_purplebug') {
            return $this->updateWhyPB();
        }
        if ($section == 'our_approach') {
            return $this->updateApproach();
        }
    }

    public function updateWhyPB()
    {
        request()->validate([
            'body' => 'required|string'
        ]);

        $content = Content::wherePage('about')->whereSection('why_purplebug')->first();
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

    public function updateApproach()
    {
        request()->validate([
            'body' => 'required|string'
        ]);

        $content = Content::wherePage('about')->whereSection('our_approach')->first();
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
}
