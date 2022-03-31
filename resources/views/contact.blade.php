@extends('layouts.app')

@section('content')
<x-header
    tag="Contact Us"
    background="/storage/banners/{{ $contents->firstWhere('section', 'banner')->contents['image'] }}"
    title="{{ $contents->firstWhere('section', 'banner')->contents['heading'] }}"
    subtitle="{!! $contents->firstWhere('section', 'banner')->contents['body']  !!}"
></x-header>

<div class="c-contact" >
    <div id="contactDetails" class="c-contact--details">
        @foreach ($contents->firstWhere('section', 'contact_details')->contents as $contact)
        <div>
            <h5>{{ $contact['heading'] }}</h5>
            @foreach ($contact['details'] as $detail)
            <p>{{ $detail }}</p>
            @endforeach
        </div>
        @endforeach
    </div>

    <div id="inquire-form" class="c-contact--inquire">
        <h1 class="inquire-get-in-touch">GET IN TOUCH WITH US</h1>

        <inquire-form url="/inquire" inline-template>
            <form id="get-in-touch" action="{{ url('inquire') }}" method="POST" autocomplete="off">
                @csrf

                <div class="form-group">
                    <label>Full Name</label>
                    <input
                        :class="`form-control e-input ${ errors.name ? 'is-invalid' : '' }`"
                        name="name"
                        type="text"
                        placeholder="Enter your name"
                        v-model="form.name"
                    >

                    <div class="invalid-feedback" v-if="errors.name" v-text="errors.name[0]"></div>
                </div>

                <div class="form-group">
                    <label>Email</label>

                    <input
                        :class="`form-control e-input ${ errors.email ? 'is-invalid' : '' }`"
                        name="email"
                        type="email"
                        placeholder="Enter your email address"
                        v-model="form.email"
                    >

                    <div class="invalid-feedback" v-if="errors.email" v-text="errors.email[0]"></div>
                </div>

                <div class="form-group">
                    <label>Contact No.</label>
                    <input
                        :class="`form-control e-input ${ errors.contact ? 'is-invalid' : '' }`"
                        name="contact"
                        type="text"
                        placeholder="Enter your contact details"
                        v-model="form.contact"
                    >

                    <div class="invalid-feedback" v-if="errors.contact" v-text="errors.contact[0]"></div>
                </div>

                <div class="form-group">
                    <label>Subject</label>

                    <select
                        :class="`form-control e-input ${ errors.subject ? 'is-invalid' : '' }`"
                        name="subject"
                        v-model="form.subject"
                    >
                        <option value="" selected disabled>Choose from the list below</option>
                        <option value="Internship Application">Internship Application</option>
                        <option value="Job Application">Job Application</option>
                        <option value="Digital Marketing Service Inquiry">Digital Marketing Service Inquiry</option>
                    </select>

                    <div class="invalid-feedback" v-if="errors.subject" v-text="errors.subject[0]"></div>
                </div>

                <div class="form-group">
                    <label>Message</label>

                    <textarea
                        :class="`form-control e-input ${ errors.message ? 'is-invalid' : '' }`"
                        name="message"
                        placeholder="Your message here..."
                        rows="4"
                        v-model="form.message"
                    ></textarea>

                    <div class="invalid-feedback" v-if="errors.message" v-text="errors.message[0]"></div>
                </div>

                <button
                    type="submit"
                    class="btn btn-block btn-purple"
                    :disabled="disabled"
                    @click.prevent="submitInquiry"
                >Inquire Now</button>
            </form>
        </inquire-form>
    </div>
</div>
@endsection

@push('seo')
<title>{{ $contents->firstWhere('section', 'seo')->contents['meta_title'] }}</title>
<meta name="description" content="{{ $contents->firstWhere('section', 'seo')->contents['meta_description'] }}">
<meta name="keywords" content="{{ $contents->firstWhere('section', 'seo')->contents['meta_keyword'] }}">
@endpush
