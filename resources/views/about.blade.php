@extends('layouts.app')

@section('content')
<x-header
    tag="About Us"
    background="/storage/banners/{{ $contents->firstWhere('section', 'banner')->contents['image'] }}"
    title="{{ $contents->firstWhere('section', 'banner')->contents['heading'] }}"
    subtitle="{!! $contents->firstWhere('section', 'banner')->contents['body']  !!}"
></x-header>

<div class="c-about__container">
    <div class="c-about">
        <!-- Nav tabs -->
        <ul class="nav c-about--nav">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#approach">Our Approach</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#why">Why Purplebug</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#subsidiaries">Purplebug Subsidiaries</a>
            </li>

            {{-- <li class="nav-item">
                <a class="nav-link" href="/our-team">Our Team</a>
            </li> --}}
        </ul>

        <!-- Tab panes -->
        <div class="tab-content c-about--content">
            <div class="tab-pane container about--approach active" id="approach">
                {!! $contents->firstWhere('section', 'our_approach')->body  !!}
            </div>

            <div class="tab-pane container about--why" id="why">
                {!! $contents->firstWhere('section', 'why_purplebug')->body  !!}
            </div>

            <div class="tab-pane container" id="subsidiaries">
                <div class="c-cards--wrapper">
                    @foreach ($subsidiaries as $subsidiary)
                    <a href="{{ $subsidiary->link ?? '#' }}" target="__blank" rel="noopener noreferrer">
                        <div class="c-card" >
                            <div class="c-cardImg--wrapper">
                                <!-- Image - 170 x 170 -->
                                <img class="c-card--img" src="{{ $subsidiary->imagePath }}" alt="" height="170" width="170">
                            </div>

                            <div class="c-card--content">
                                <h5>{{ $subsidiary->title }}</h5>
                                <div>{!! $subsidiary->body !!}</div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div id="inquire-form" class="service-inquire mt-5">
        <div class="text-center c-cant-find">
            <p class="font-weight-normal inquire-looking-for">Can't find what you're looking for?</p>
        </div>

        <inquire-form url="/service/inquire#inquire-form" inline-template>
            <form id="get-in-touch" class="inquire-form mt-5" action="{{ url('service/inquire#inquire-form') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-xs-12 col-sm-6">
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

                    <div class="col-xs-12 col-sm-6">
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
                </div>

                <div class="row mt-4">
                    <div class="col-xs-12 col-sm-6">
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

                    <div class="col-xs-12 col-sm-6">
                        <label>Subject</label>

                        <select
                            :class="`form-control e-input ${ errors.subject ? 'is-invalid' : '' }`"
                            name="subject"
                            v-model="form.subject"
                        >
                            <option value="" selected disabled>Choose from the list below</option>

                            @foreach ($services as $subject)
                            <option value="{{ $subject->slug }}">
                                {{ $subject->title }}
                            </option>
                            @endforeach
                        </select>

                        <div class="invalid-feedback" v-if="errors.subject" v-text="errors.subject[0]"></div>
                    </div>
                </div>

                <div class="form-group mt-4">
                    <label>Message</label>

                    <textarea
                        :class="`form-control e-input ${ errors.message ? 'is-invalid' : '' }`"
                        name="message"
                        rows="5"
                        placeholder="Your message here..."
                        v-model="form.message"
                    ></textarea>

                        <div class="invalid-feedback" v-if="errors.message" v-text="errors.message[0]"></div>
                </div>

                <div class="text-center mt-4">
                    <button
                        type="submit"
                        class="btn btn-purple"
                        :disabled="disabled"
                        @click.prevent="submitInquiry"
                    >Inquire Now</button>
                </div>
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
