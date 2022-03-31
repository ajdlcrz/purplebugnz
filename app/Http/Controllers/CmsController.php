<?php

namespace App\Http\Controllers;

use App\Exports\ActivitiesExport;
use App\Faq;
use App\Http\Resources\ActivityLogResource;
use App\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Activitylog\Models\Activity;

class CmsController extends Controller
{
    // DASHBOARD
    public function index()
    {
        $latestActivities = Activity::latest()->take(5)->get();

        $latestAddedUser = Activity::whereHasMorph(
            'subject',
            ['\App\User'],
            function (Builder $query) {
                $query->where('description', 'like', 'created%');
            }
        )->latest()->take(5)->get();

        $latestAddedBlog = Activity::whereHasMorph(
            'subject',
            ['\App\Blog'],
            function (Builder $query) {
                $query->where('description', 'like', 'created%');
            }
        )->latest()->take(5)->get();

        return view('cms.dashboard', compact('latestActivities', 'latestAddedUser', 'latestAddedBlog'));
    }

    public function activities()
    {
        return view('cms.activities');
    }

    public function exportActivities($column, $order)
    {
        if (Activity::count() > 0) {
            activity()->log('Exported Activity Logs');
            return Excel::download(new ActivitiesExport($column, $order), 'activity_logs.xlsx');
        }

        return back()->with(['message' => 'No Records to Export', 'status' => 'info']);
    }

    public function activityLogs()
    {
        $query = Activity::orderBy(request('column'), request('order'));

        return ActivityLogResource::collection($query->paginate(request('per_page')));
    }

    public function pages()
    {
        return view('cms.page-management');
    }

    // MY ACCOUNT
    public function myAccount()
    {
        $roles = Role::all();
        return view('cms.my_account', compact('roles'));
    }

    public function updatePassword()
    {
        request()->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6'
        ]);

        if (!Hash::check(request('old_password'), auth()->user()->password)) {
            // replicates the laravel's validation json response.
            return response()->json(['errors' => [
                'old_password' => ['Invalid Password!']
            ]], 422);
        }

        auth()->user()->update([
            'password' => bcrypt(request('new_password'))
        ]);

        activity()->performedOn(auth()->user())->log('changed password');

        return response()->json(['success' => 'Password Successfully Updated!'], 200);
    }

    // FAQS
    public function faqs()
    {
        $faqs = \Cache::rememberForever('faqs', function () {
            return Faq::get();
        });

        return view('cms.faqs', compact('faqs'));
    }

    public function storeFaq()
    {
        $attr = request()->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string'
        ]);

        Faq::create($attr);

        return back()->with(['message' => 'FAQ created.']);
    }

    public function updateFaq(Faq $faq)
    {
        $attr = request()->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string'
        ]);

        $faq->update($attr);

        return back()->with(['message' => 'FAQ updated.']);
    }
}
