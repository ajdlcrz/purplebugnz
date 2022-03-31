<?php

namespace App\Http\Controllers;

use App\Rules\ValidCaptcha;
use App\Subscriber;

class SubscriberController extends Controller
{
    public function subscribe()
    {
        $attr = request()->validate([
            'email' => 'required|email|unique:subscribers',
            'recaptcha' => ['required', new ValidCaptcha]
        ]);

        Subscriber::create($attr);

        return redirect(url()->previous() . "#subscribeForm")->with(['status' => 'success', 'message' => 'Successfully subscribed.']);
    }
}
