<?php

namespace App\Http\Controllers;

use App\Content;
use Spatie\Activitylog\Contracts\Activity;

class ContactController extends Controller
{
    public function contact()
    {
        $contents = Content::wherePage('contact')->get();
        return view('contact', compact('contents'));
    }

    // -- -- -- CMS SIDE -- -- --
    public function index()
    {
        return view('cms.pages.contact');
    }

    public function getContents()
    {
        if (request()->ajax()) {
            return response(['contents' => Content::wherePage('contact')->get()], 200);
        }
    }

    public function updateContacts()
    {
        request()->validate([
            'heading' => 'required|string|max:255',
        ]);

        $contactDetails = Content::wherePage('contact')->whereSection('contact_details')->first();
        $requestDetails = request()->except(['originalData', 'errors']);

        if (in_array(request('id'), array_column($contactDetails->contents, 'id'))) {
            $contents = $contactDetails->contents; // prevents indirect modification
            $index = array_search(request('id'), array_column($contents, 'id')); // search the index of the contact

            // updates existing contact
            $oldDetails =  $contactDetails->contents[$index];
            $contents[$index] = $requestDetails;

            $contactDetails->update(['contents' => $contents]);

            if ($oldDetails !== $contents[$index]) {
                activity()->performedOn($contactDetails)
                    ->tap(function (Activity $activity) use ($oldDetails, $contents, $index) {
                        $activity->properties = [
                            'old' => $oldDetails,
                            'attributes' => $contents[$index],
                        ];
                    })
                    ->log('Updated a content');
            }
        } else {
            // append new contact
            $contactDetails->update([
                'contents' => array_merge($contactDetails->contents, [$requestDetails])
            ]);

            activity()->performedOn($contactDetails)
                ->tap(function (Activity $activity) use ($requestDetails) {
                    $activity->properties = [
                        'attributes' => $requestDetails,
                    ];
                })
                ->log('Created a content');
        }

        return response()->json([
            'success' => 'Contact details successfully saved.',
            'contact' => collect($requestDetails)->put('originalData', $requestDetails)
        ], 200);
    }

    public function deleteContact($contact)
    {
        $contactDetails = Content::wherePage('contact')->whereSection('contact_details')->first();

        if (in_array($contact, array_column($contactDetails->contents, 'id'))) {
            $contents = $contactDetails->contents;
            $index = array_search($contact, array_column($contents, 'id'));

            activity()->performedOn($contactDetails)
                ->tap(function (Activity $activity) use ($contents, $index) {
                    $activity->properties = [
                        'attributes' => $contents[$index],
                    ];
                })
                ->log('Removed a content');

            // removes the item from the array
            array_splice($contents, $index, 1);

            $contactDetails->update(['contents' => $contents]);

            return response()->json(['success' => 'Contact details has been removed.'], 200);
        }
    }
}
