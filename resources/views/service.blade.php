@extends('layouts.app')

@section('content')
<x-header
    tag="Services"
    background="{{ $service->bannerPath }}"
    title="{{ $service->title }}"
    subtitle="{!! $service->description !!}">
</x-header>

<div class="c-service-innerWrap">
    <div class="c-service-inner">
        <div class="row">
            <div class="col-md-3">We Offer</div>

            <div class="col we-offer--content">
                @foreach ($service->offers as $offer)
                <div>
                    <p class="offer-heading">{{ $offer['heading'] }}</p>

                    <div class="offer-body text-justify">{!! $offer['body'] !!}</div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-3">Did You Know</div>

            <div class="col-md-9 dyk--content">
                {!! $service->facts !!}
            </div>
        </div>
    </div>

    <div class="c-service-testimonials">
        <div class="row justify-content-between">
            <div class="col-md-3">Let's Hear It From Them</div>

            <div class="col-md-8">
                <div class="testimonials-wrapper">
                    @forelse ($service->testimonials as $testimonial)
                    <div class="brand-testimonial">
                        <div class="brand-info">
                            <!-- Image - 110x110 -->
                            <img class="rounded brand-thumbnail mr-3" src="{{ $testimonial->imagePath ?? '/img/placeholders/employee.png' }}" alt="partner-image">

                            <div class="brand-details">
                                <p>{{ $testimonial->name }}</p>
                                <p>{{ $testimonial->position }}</p>
                            </div>
                        </div>

                        <div class="brand-review mt-3 mb-0">{!! $testimonial->body !!}</div>
                    </div>
                    @empty
                    <p>No Testimonials yet.</p>
                    @endforelse

                    @if (!count($service->testimonials) == 0)
                    <button id="loadMore" class="btn btn-outline-secondary">Load More</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if ($service->slug == 'influencer-circle')
    <div class="c-service-influencer">
        <div class="nav nav-tabs">
            <a class="nav-link active" data-toggle="tab" href="#inquire-form">
                Looking for an influencer <span class="d-block">for your brand?</span>
            </a>
            <a class="nav-link" data-toggle="tab" href="#influencer-form">
                Are you an Influencer? <span class="d-block">Join us!</span>
            </a>
        </div>

        <div class="tab-content">
            <div id="inquire-form" class="tab-pane show active service-inquire p-0 border-bottom-0">
                <div class="text-center c-cant-find">
                    <h2 class="font-weight-normal inquire-looking-for" style="font-size: 32px;">Power your business with Influencer Circle</h2>
                </div>

                <inquire-form url="/service/inquire#inquire-form" :service="{{ $service }}" inline-template>
                    <form id="get-in-touch" class="inquire-form mx-auto mt-5" action="{{ url('service/inquire#inquire-form') }}" method="POST">
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
                                    type="tel"
                                    placeholder="Enter your contact details"
                                    v-model="form.contact"
                                >

                                <div class="invalid-feedback" v-if="errors.contact" v-text="errors.contact[0]"></div>
                            </div>

                            <div class="col-xs-12 col-sm-6">
                                <label>Subject</label>

                                <input name="subject" type="hidden" v-model="form.subject">
                                <input
                                    type="text"
                                    placeholder="Enter your contact details"
                                    readonly
                                    :class="`form-control e-input ${ errors.subject ? 'is-invalid' : '' }`"
                                    value="{{ $service->title }}"
                                    style="background-color: transparent;"
                                >

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

            <div id="influencer-form" class="tab-pane c-service-influencer__pane">
                <h6 class="text-center font-weight-normal">Showcase your creativity, personal connection, social media community outreach and together, let's produce compelling content that can grab the brands customers' attention.</h6>

                <div class="mt-4">
                    <p class="mb-2 text-center">Still got questions?</p>

                    <div class="d-flex flex-column align-items-center">
                        <button class="btn btn-outline-purple" data-toggle="modal" data-target="#faqs-modal">See FAQs</button>
                        <influencer-form></influencer-form>
                    </div>
                </div>

                <!-- FAQs-Modal -->
                <div class="modal fade" id="faqs-modal" tabindex="-1">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header border-0">
                                <h5 class="modal-title font-weight-bold c-font--purple">Frequently Asked Questions</h5>
                            </div>

                            <div class="modal-body">
                                <div class="accordion" id="faqsAccordion">
                                    <div class="card mb-0">
                                        <div class="card-header">
                                            <h2>
                                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#faqsOne">
                                                    How do I qualify to be part of the Influencer Circle?
                                                </button>
                                            </h2>
                                        </div>

                                        <div id="faqsOne" class="collapse show"  data-parent="#faqsAccordion">
                                            <div class="card-body">
                                                To be a part of the Influencer Circle, you must be active on Instagram, Facebook, YouTube or TiktTok. You are likely to be an amateur chef, Mom, Dad,  foodie, fashionista, avid traveler, keen photographer, fitness or sports freak, artist, or designer and many more. Aside from that, you would have achieved a certain number of followers and gained significant levels of engagement ("likes" and comments) for each of your social media pages. As we determine if you passed the qualifications to be one of our influencers.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card mt-3 mb-0">
                                        <div class="card-header">
                                            <h2>
                                                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#faqsTwo">
                                                    How do I participate in campaign?
                                                </button>
                                            </h2>
                                        </div>

                                        <div id="faqsTwo" class="collapse" data-parent="#faqsAccordion">
                                            <div class="card-body">
                                                For the campaigns after successfully qualifying to be a part of the Influencer Circle, We'll be adding you in our Influencers List and will be contacting you for Future Projects that would fit your advocacy and expertise.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card mt-3 mb-0">
                                        <div class="card-header">
                                            <h2>
                                                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#faqsThree">
                                                    Does Influencer Circle have exclusive contracts?
                                                </button>
                                            </h2>
                                        </div>

                                        <div id="faqsThree" class="collapse" data-parent="#faqsAccordion">
                                            <div class="card-body">
                                                Yes,  we will provide an exclusive contract based on the brand agreement that you will be promote for.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card mt-3 mb-0">
                                        <div class="card-header">
                                            <h2>
                                                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#faqsFour">
                                                    How will I be compensated?
                                                </button>
                                            </h2>
                                        </div>

                                        <div id="faqsFour" class="collapse" data-parent="#faqsAccordion">
                                            <div class="card-body">
                                                For the compensation we will base it on your rate and the brands offer.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer mb-3 border-0">
                                <button type="button" class="btn btn-purple mx-auto" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div id="inquire-form" class="service-inquire">
        <div class="text-center c-cant-find">
            <p class="font-weight-normal inquire-looking-for">Can't find what you're looking for?</p>
        </div>

        <inquire-form url="/service/inquire#inquire-form" :service="{{ $service }}" inline-template>
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
                            type="tel"
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
    @endif
</div>
@endsection

@push('seo')
    <title>{{ $service->seo['meta_title'] }}</title>
    <meta name="description" content="{{ $service->seo['meta_description'] }}">
    <meta name="keywords" content="{{ $service->seo['meta_keywords'] }}">
@endpush
