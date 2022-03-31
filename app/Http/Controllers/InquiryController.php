<?php

namespace App\Http\Controllers;

use App\Influencer;
use App\Inquiry;
use App\Mail\InfluencerRegistrationMail;
use App\Mail\InquiryMail;
use App\Rules\ValidCaptcha;
use App\Service;
use Mail;

class InquiryController extends Controller
{
    const mainRecipient = 'support@purplebugmail.net';
    const otherRecipients = [
        'jc.lucaylucay@purplebugmail.net',
        'legal@purplebugmail.net',
        'jovelyn.salcedo@purplebugmail.net',
        'seosupport@purplebugmail.net',
        'admin@purplebugmail.net',
        'arn.ruiz@purplebugmail.net'
    ];

    public function inquire()
    {
        $attr = request()->validate([
            'name' => "required|regex:/^[a-zÑñ ,.'-]+$/i|max:50",
            'contact' => 'required|numeric|digits_between:7,20',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required|max:255',
            'recaptcha' => ['required', new ValidCaptcha]
        ]);

        $inquiry = Inquiry::create(array_merge($attr, [
            'contact_subject' => request('subject')
        ]));

        $mail = Mail::to(self::mainRecipient);
        if (app()->environment('production')) {
            $mail->cc(self::otherRecipients);
        }
        $mail->send(new InquiryMail($inquiry));

        return response(['status' => 'success', 'message' => 'Inquiry successfully sent'], 200);
    }

    public function serviceInquire()
    {
        $attr = request()->validate([
            'name' => "required|regex:/^[a-zÑñ ,.'-]+$/i|max:50",
            'contact' => 'required|numeric|digits_between:7,20',
            'email' => 'required|email',
            'subject' => 'required|max:255|exists:services,slug',
            'message' => 'required|max:255',
            'recaptcha' => ['required', new ValidCaptcha]
        ]);

        $service = Service::whereSlug(request('subject'))->firstOrFail();
        $inquiry = Inquiry::create(array_merge($attr, [
            'service_id' => $service->id
        ]));

        $mail = Mail::to(self::mainRecipient);
        if (app()->environment('production')) {
            $mail->cc(self::otherRecipients);
        }
        $mail->send(new InquiryMail($inquiry, $service));

        return response(['status' => 'success', 'message' => 'Service Inquiry successfully sent']);
    }

    public function storeInfluencer()
    {
        $rules = [];

        if (request('current_step') == 1 || request('current_step') == 'all') {
            $rules = array_merge($rules, [
                'name' => "required|regex:/^[a-zÑñ ,.'-]+$/i|max:50",
                'age' => 'required|numeric|min:13', // coppa under 13
                'sex' => 'required|string|in:male,female',
                'contact_number' => 'required|numeric|digits_between:7,20',
                'email' => 'required|email|unique:influencers',
            ]);
        }

        if (request('current_step') == 2 || request('current_step') == 'all') {
            $rules = array_merge($rules, [
                "content_category" => ['required', function ($attribute, $value, $fail) {
                    $total = 0;
                    foreach ($value as $val) {
                        if ($val == false || empty($val)) {
                            $total++;
                        }
                    }

                    if ($total == 6) {
                        $fail('The content category is required.');
                    }
                }],
                "total_followers" => "required|numeric",
            ]);
        }

        if (request('current_step') == 3 || request('current_step') == 'all') {
            $rules = array_merge($rules, [
                'facebook_page_url' =>  $this->validatePageUrl('facebook') || empty(request('facebook_page_url')) ? ['required', 'string', 'in:n/a,N/A'] : ['url', 'regex:/http(?:s):\/\/(www|m)\.facebook\.com\/.+/i'],
                'facebook_post_rate' => "required|string|max:255",
                'instagram_page_url' =>  $this->validatePageUrl('instagram') || empty(request('instagram_page_url')) ? ['required', 'string', 'in:n/a,N/A'] : ['url', 'regex:/http(?:s):\/\/(www|m)\.instagram\.com\/.+/i'],
                'instagram_post_rate' => "required|string|max:255",
                'instagram_video_post_rate' => "required|string|max:255",
            ]);
        }

        if (request('current_step') == 4 || request('current_step') == 'all') {
            $rules = array_merge($rules, [
                'youtube_page_url' =>  $this->validatePageUrl('youtube') || empty(request('youtube_page_url')) ? ['required', 'string', 'in:n/a,N/A'] : ['url', 'regex:/http(?:s):\/\/(www|m)\.youtube\.com\/.+/i'],
                'youtube_post_rate' => 'required|string|max:255',
                'instagram_page_url' =>  $this->validatePageUrl('instagram') || empty(request('instagram_page_url')) ? ['required', 'string', 'in:n/a,N/A'] : ['url', 'regex:/http(?:s):\/\/(www|m)\.instagram\.com\/.+/i'],
                'tiktok_post_rate' => 'required|string|max:255',
            ]);
        }

        $validated = request()->validate($rules);

        if (request('current_step') == 'all') {
            request()->validate([
                'recaptcha' => ['required', new ValidCaptcha]
            ]);

            $Influencer = Influencer::create(array_merge($validated, [
                'facebook' => [
                    'page_url' => request('facebook_page_url'),
                    'post_rate' => request('facebook_post_rate'),
                ],
                'instagram' => [
                    'page_url' => request('instagram_page_url'),
                    'post_rate' => request('instagram_post_rate'),
                    'video_post_rate' => request('instagram_video_post_rate'),
                ],
                'youtube' => [
                    'page_url' => request('youtube_page_url'),
                    'post_rate' => request('youtube_post_rate'),
                ],
                'tiktok' => [
                    'page_url' => request('tiktok_page_url'),
                    'post_rate' => request('tiktok_post_rate'),
                ],
            ]));

            $mail = Mail::to("influencermgmt@purplebugmail.net");
            if (app()->environment('production')) {
                $mail->cc([
                    'jc.lucaylucay@purplebugmail.net',
                    'support@purplebugmail.net'
                ]);
            }
            $mail->send(new InfluencerRegistrationMail($Influencer));

            return response(['success' => 'Registration Successful.'], 200);
        }
    }

    public function validatePageUrl($domain)
    {
        return request("{$domain}_page_url") == 'n/a' || request("{$domain}_page_url") == 'N/A';
    }
}
