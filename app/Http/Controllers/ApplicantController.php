<?php

namespace App\Http\Controllers;

use App\Applicant;
use App\Career;
use App\Exports\ApplicantsExport;
use App\Mail\ApplyMail;
use App\Rules\ValidCaptcha;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ApplicantController extends Controller
{
    public function apply()
    {
        $attr = request()->validate(([
            'recaptcha' => ['required', new ValidCaptcha],
            'position' => 'required|exists:careers,slug',
            'name' => "required|regex:/^[a-zÑñ ,.'-]+$/i|max:50",
            'contact' => 'required|numeric|digits_between:7,20',
            'address' => 'required',
            'email' => 'required|email',
            'file' => ['required', 'max:3072', function ($attribute, $value, $fail) {
                $mimes = collect(['pdf', 'doc', 'docx']);

                if (!$mimes->contains(request()->file('file')->getClientOriginalExtension())) {
                    $fail('The file must be a type of .pdf, .doc, .docx');
                }
            }],
        ]));
        unset($attr['position']);

        $career = Career::whereSlug(request('position'))->first();
        $fileName = Str::slug(request('name'), '-') . '-' . substr(uniqid(), 7) . '.' . request()->file('file')->getClientOriginalExtension();

        $applicant = Applicant::create(array_merge($attr, [
            'career_id' => $career->id,
            'file' => $fileName
        ]));

        request()->file('file')->storeAs('applicants/', $fileName);

        \Mail::to('support@purplebugmail.net')
            ->cc([
                'jovelyn.salcedo@purplebugmail.net',
                'inquiries@purplegmail.net',
                'admin@purplebugmail.net',
            ])
            ->send(new ApplyMail($applicant, $career, $fileName));

        return response()->json(['success' => 'Application Success!'], 200);
    }

    // == == == CMS SIDE == == ==
    public function update(Applicant $applicant)
    {
        request()->validate([
            'status' => 'required|string'
        ]);

        $oldApplicant = $applicant->replicate();

        $applicant->update([
            'status' => request('status')
        ]);

        return response(['success' => "Status changed from \"" . Str::title($oldApplicant->status) . "\" into \"" . Str::title($applicant->status) . "\""], 200);
    }

    public function exportApplicant()
    {
        $status = Str::slug(request('status'));

        if (Applicant::count() > 0) {
            $fileName = "{$status}-applicants";

            if (request('startDate') && request('endDate')) {
                $fileName .= '-' . request('startDate') . '_to_' . request('endDate');
            }

            activity()->log('Exported Applicant Records');
            return Excel::download(new ApplicantsExport(request()->all()), "{$fileName}.xlsx");
        }

        return back()->with(['message' => 'No Records to Export', 'status' => 'info']);
    }

    public function downloadResume(Applicant $applicant)
    {
        if (Storage::exists("/applicants/{$applicant->file}")) {
            activity()->log("Downloaded {$applicant->name}'s file");
            return response()->download(public_path("/storage/applicants/{$applicant->file}"));
        }

        return "File does not exists.";
    }

    public function applicants()
    {
        $query = Applicant::with('career')
            ->where(function ($query) {
                $keyword = request('filter');

                $query->where('name', 'like', "%{$keyword}%")
                    ->orWhere('contact', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%")
                    ->orWhere('address', 'like', "%{$keyword}%")
                    ->orWhereHas('career', function ($query) use ($keyword) {
                        $query->where('title', 'like', "%{$keyword}%");
                    })
                    ->orWhere('applicants.status', 'like', "%{$keyword}%")
                    ->orWhere('applicants.created_at', 'like', "%{$keyword}%");
            })
            ->when(request('filterStatus'), function ($queryStatus, $status) {
                $queryStatus->where('applicants.status', $status);
            })
            ->when(request('column') == 'career', function ($query) {
                return $query->join('careers', 'applicants.career_id', '=', 'careers.id')
                    ->orderBy('careers.title', request('order'))
                    ->select('applicants.*');
            }, function ($query) {
                return $query->orderBy(request('column'), request('order'));
            });

        return JsonResource::collection($query->paginate(request('per_page')));
    }
}
