<?php

namespace App\Http\Controllers;

use App\Insight_Inquiry;
use App\Rules\ValidCaptcha;
use Illuminate\Http\Request;

class InsightInquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Insight_Inquiry  $insight_Inquiry
     * @return \Illuminate\Http\Response
     */
    public function show(Insight_Inquiry $insight_Inquiry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Insight_Inquiry  $insight_Inquiry
     * @return \Illuminate\Http\Response
     */
    public function edit(Insight_Inquiry $insight_Inquiry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Insight_Inquiry  $insight_Inquiry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Insight_Inquiry $insight_Inquiry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Insight_Inquiry  $insight_Inquiry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Insight_Inquiry $insight_Inquiry)
    {
        //
    }
    public function inquire()
    {
        $attr = request()->validate([
            'title' => 'required',
            'name' => "required|regex:/^[a-zÑñ ,.'-]+$/i|max:50",
            'company' => 'required',
            'email' => 'required|email',
            'contact_manager' => 'required',
            'recaptcha' => ['required', new ValidCaptcha],
        ]);

        Insight_Inquiry::create($attr);

        return response(['status' => 'success', 'message' => 'Insight Inquiry successfully sent'], 200);
    }
}
