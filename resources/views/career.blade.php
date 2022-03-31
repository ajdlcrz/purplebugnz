@extends('layouts.app')

@section('content')
@if ($career->banner)
<header>
    <!-- Banner Image - 1920 x 614 -->
    <div class="c-banner p-0">
        <img class="w-100" src="{{ asset($career->bannerPath) }}" alt="{{ $career->slug }}">
    </div>
</header>
@endif


<div class="c-career">
    <div class="inner-page-breadcrumb">
        <a class="breadcrumb-link" href="{{ url('careers') }}">Back to Careers</a>
    </div>

    <div class="job-more-details">
        <div class="careers-item">
            <h4 class="job-title">{{ $career->title }}</h4>
            <div class="job-details">
                <div class="job-department">
                    <p>Department</p>
                    <small>{{ $career->department }}</small>
                </div>

                <div>
                    <p>Years of Experience</p>
                    <small>{{ $career->experience }}</small>
                </div>

                <div>
                    <p>Status</p>
                    <small class="job-status">{{ $career->status ? 'Active' : 'Not Active' }}</small>
                </div>
            </div>
        </div>

        <div class="job-description">
            <p class="font-weight-bold">Overview</p>
            {!! $career->overview !!}

            <p class="font-weight-bold">Requirements</p>
            {!! $career->requirements !!}
        </div>

        <div class="job-details-footer">
            <a href="{{ url()->current() . '/apply' }}" class="btn btn-purple">Apply</a>

            <span class="btn-share">Share</span>

            <div class="d-flex align-items-end">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" class="btn btn-link">
                    <img src="{{ url("img/icon-fb.svg") }}" alt="fb icon">
                </a>

                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ url()->current() }}" class="btn btn-link">
                    <img src="{{ url("img/icon-linkedin.svg") }}" alt="linkedin icon">
                </a>

                <a class="btn btn-link d-flex" href="mailto:?subject={{ $career->seo['meta_title'] }}&amp;body=Check Job Post here {{ url()->current() }}">
                    <img src="{{ url("img/icon-email.svg") }}" alt="email icon">
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('seo')
    <!-- generic meta tags -->
    <title>{{ $career->seo['meta_title'] }}</title>
    <meta name="description" content="{{ $career->seo['meta_description'] }}">
    <meta name="keywords" content="{{ $career->seo['meta_keywords'] }}">

    <!-- fb|linkedin meta tags -->
    <meta property="og:title"         content="{{ $career->seo['meta_title'] }}" />
    <meta property="og:description"   content="{{ strip_tags($career->details) }}" />
    <meta property="og:type"          content="article" />
    <meta property="og:url"           content="{{ url("career/" . $career->slug) }}" />
@endpush