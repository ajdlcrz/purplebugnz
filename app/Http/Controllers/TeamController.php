<?php

namespace App\Http\Controllers;

use App\Content;
use App\Team;
use App\TeamPhoto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Activitylog\Contracts\Activity;

class TeamController extends Controller
{
    public function team()
    {
        $contents = Content::wherePage('teams')->get();
        $team = Team::orderBy('order')->get();
        $team_photos = TeamPhoto::get();

        return view('team', compact('contents', 'team', 'team_photos'));
    }

    // -- -- -- CMS SIDE -- -- --
    public function index()
    {
        return view('cms.pages.teams');
    }

    public function getContents()
    {
        if (request()->ajax()) {
            return response(['contents' => Content::wherePage('teams')->get()], 200);
        }
    }

    public function updateContent($section)
    {
        if ($section == 'who_we_are') {
            return $this->updateWhoWe($section);
        }
        if ($section == 'executives') {
            return $this->updateExecutives($section);
        }
        if ($section == 'join_our_team') {
            return $this->updateJoinTeam($section);
        }
    }

    // TEAM PHOTOS SECTION == == ==
    public function listPhotos()
    {
        return response(['photos' => TeamPhoto::get()], 200);
    }

    public function addPhoto()
    {
        // request()->validate([
        //     'image' => 'required|mimes:jpeg,jpg,png|max:5120|dimensions:max_width=676,max_height=561',
        // ]);

        if (request()->hasFile('image')) {
            $fileName = request()->file('image')->getClientOriginalName();

            if (TeamPhoto::whereImage($fileName)->first()) {
                $fileName = uniqid() . $fileName;
            }

            request()->file('image')->storeAs('teams/photos/', $fileName);
            \Image::make(public_path("/storage/teams/photos/{$fileName}"))
                ->resize(676, 561, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();
        }

        $photo = TeamPhoto::create([
            'image' => $fileName
        ]);

        return response()->json([
            'success' => 'Photo Uploaded!',
            'photo' => $photo
        ], 200);
    }

    public function deletePhoto(TeamPhoto $photo)
    {
        Storage::delete("teams/photos/{$photo->image}");
        $photo->delete();

        return response()->json(['success' => 'Photo Deleted!'], 200);
    }

    public function updateWhoWe($section)
    {
        request()->validate([
            'body' => 'required'
        ]);

        $content = Content::wherePage('teams')->whereSection($section)->first();
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

    public function updateExecutives($section)
    {
        request()->validate([
            'image' => 'nullable|mimes:jpeg,jpg,png|max:5120|dimensions:max_width=631,max_height=688',
            'name' => 'required|string|max:60',
            'position' => 'required|string|max:60',
            'body' => 'required',
        ]);

        $executives = Content::wherePage('teams')->whereSection($section)->first();
        $requestExecutive = request()->except(['_method']);

        // check if request has image before uploading
        if (request()->hasFile('image')) {
            $fileName = Str::slug(request('name'), '_') . '.' . request()->file('image')->getClientOriginalExtension();

            request()->file('image')->storeAs('teams/executives/', $fileName);
            \Image::make(public_path('/storage/teams/executives/' . '/' . $fileName))
                ->resize(631, 688, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $requestExecutive['image'] = $fileName;
        }

        $contents = $executives->contents; // prevents indirect modification

        // if file exists & new filename
        $executiveImage = $contents[request('index')]['image'];

        // reapply the image original value if no new image because remove front frontend logic
        if (!array_key_exists('image', $requestExecutive)) {
            $requestExecutive['image'] = $executiveImage;
        }

        if (Storage::exists("/teams/executives/{$executiveImage}") && $executiveImage !== $requestExecutive['image']) {
            Storage::delete("/teams/executives/{$executiveImage}");
        }

        // updates existing banner
        unset($requestExecutive['index'], $requestExecutive['tempImage']);
        $oldExecutive =  $executives->contents[$index = request('index')];
        $contents[request('index')] = $requestExecutive;

        $executives->update(['contents' => $contents]);

        if ($oldExecutive != $contents[request('index')]) {
            activity()->performedOn($executives)
                ->tap(function (Activity $activity) use ($oldExecutive, $contents, $index) {
                    $activity->properties = [
                        'old' => $oldExecutive,
                        'attributes' => $contents[$index],
                    ];
                })
                ->log('Updated a content');
        }

        return response()->json([
            'success' => 'Executive has been updated',
            'executive' => $requestExecutive
        ], 200);
    }

    public function updateJoinTeam($section)
    {
        request()->validate([
            'body' => 'required',
            'link' => 'required|url'
        ]);

        $content = Content::wherePage('teams')->whereSection($section)->first();
        $oldContent = $content->replicate();

        $content->update([
            'contents' => request()->except(['errors'])
        ]);

        if ($oldContent->contents !== $content->contents) {
            activity()->performedOn($content)
                ->tap(function (Activity $activity) use ($oldContent, $content) {
                    $activity->properties = [
                        'old' => $oldContent->contents,
                        'attributes' => $content->contents
                    ];
                })
                ->log('Updated a content');
        }

        return response()->json(['success' => 'Updated!'], 200);
    }

    // EMPLOYEES CRUD
    public function store()
    {
        request()->validate([
            'image' => 'required|mimes:jpeg,jpg,png|max:2048|dimensions:max_width=640,max_height=413',
            'name' => 'required|string',
            'position' => 'required|string',
        ]);

        if (request()->hasFile('image')) {
            $fileName = uniqid() . Str::slug(request('name'), '_') . '.' . request()->file('image')->getClientOriginalExtension();

            request()->file('image')->storeAs('teams/employees/', $fileName);
            \Image::make(public_path("/storage/teams/employees/{$fileName}"))
                ->resize(640, 413, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();
        }

        $employee = Team::create([
            'image' => $fileName ?? null,
            'name' => request('name'),
            'position' => request('position'),
        ]);

        return response()->json([
            'success' => 'Employee successfully saved.',
            'employee' => collect($employee)->put('originalData', $employee)
        ], 200);
    }

    public function update(Team $employee)
    {
        request()->validate([
            'image' => 'nullable|mimes:jpeg,jpg,png|max:2048|dimensions:max_width=640,max_height=413',
            'name' => 'required|string',
            'position' => 'required|string',
        ]);

        if (request()->hasFile('image')) {
            $fileName = uniqid() . Str::slug(request('name'), '_') . '.' . request()->file('image')->getClientOriginalExtension();

            request()->file('image')->storeAs('teams/employees/', $fileName);
            \Image::make(public_path("/storage/teams/employees/{$fileName}"))
                ->resize(640, 413, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();
        }

        $imageName = $fileName ?? $employee->image;

        if (Storage::exists("teams/employees/{$employee->image}") && $employee->image !== $imageName) {
            Storage::delete("teams/employees/{$employee->image}");
        }

        $employee->update([
            'image' => $imageName,
            'name' => request('name'),
            'position' => request('position'),
            'order' => request('order'),
        ]);

        return response()->json([
            'success' => 'Employee successfully saved.',
            'employee' => collect($employee)->put('originalData', $employee)
        ], 200);
    }

    public function destroy(Team $employee)
    {
        if (Storage::exists("teams/employees/{$employee->image}")) {
            Storage::delete("teams/employees/{$employee->image}");
        }
        $employee->delete();

        return response()->json(['success' => 'Employee has been deleted!'], 200);
    }

    public function employees()
    {
        return response(['employees' => Team::orderBy('order')->get()], 200);
    }

    public function updateAllEmployees()
    {
        foreach (request('employees') as $employee) {
            $employeeRow = Team::find($employee['id']);
            $employeeRow->timestamps = false;
            $employeeRow->update([
                'order' => $employee['order']
            ]);
        }

        return response()->json([
            'success' => 'Employee order successfully updated.',
        ], 200);
    }
}
