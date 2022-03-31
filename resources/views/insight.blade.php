@extends('layouts.app')

@section('content')
<div>
    <div class="c-blog-inner">
        <div class="inner-page-breadcrumb">
            <a class="breadcrumb-link" href="{{ url('blogs') }}">Back to Insights</a>
        </div>

        <div class="row mt-4">
            <div class="col-md-9 blog-details">
                <div class="c-blog">
                    <div class="c-blog--img">
                        <!-- Banner Image - 951 x 616 -->
                        <img src="{{ $insight->bannerPath }}" alt="{{ $insight->alt_text }}">
                    </div>

                    <div class="c-blog--body flex-column">
                        <div>
                            <p class="c-blog--tag"></p>
                            <h1 class="c-blog--title mt-3">{{ $insight->title}}</h1>
                            <small class="c-blog--tag">{{ $insight->published_at }}</small>
                        </div>

                        <div class="c-blog--content">
                            {!! $insight->details !!}
                        </div>
                        <div class="report-button w-100">
                            <insight-inner insight-title="{{ $insight->title }}"></insight-inner>
                        </div>
                    </div>
                </div>

                <div class="mt-5 pb-5">
                    <div class="c-footer-policy">
                        <span>Share</span>
                        <div class="c-footer-social mt-2">
                            <a class="social-button" href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}">
                                <img src="{{ url("img/icon-fb.svg") }}" alt="fb icon">
                            </a>

                            <a class="social-button" href="https://www.linkedin.com/sharing/share-offsite/?url={{ url()->current() }}">
                                <img src="{{ url("img/icon-linkedin.svg") }}" alt="linkedin icon">
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 similar-blogs">
                <span>Similar</span>

                <div class="similar-blog-wrap">
                    @foreach ($similar as $similar)
                    <a href="{{ url("insight/{$similar->slug}") }}" class="c-blog">
                        <div class="c-blog--img">
                            <img src="{{ $similar->thumbnailPath }}" alt="{{ $similar->alt_text }}">
                        </div>

                        <div class="c-blog--body">
                            <div>
                                <h6 class="c-blog--title">
                                    {{ $similar->title }}
                                </h6>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <recent-insights page-name="innerInsight" insight-slug="{{ $insight->slug }}"></recent-insights>
</div>
@endsection

@push('seo')
    <!-- generic meta tags -->
    <title>{{ $insight->seo['meta_title'] }}</title>
    <meta name="description" content="{{ $insight->seo['meta_description'] }}">
    <meta name="keywords" content="{{ $insight->seo['meta_keywords'] }}">

    <!-- fb|linkedin meta tags -->
    <meta property="og:title"         content="{{ $insight->seo['meta_title'] }}" />
    <meta property="og:description"   content="{{ strip_tags($insight->details) }}" />
    <meta property="og:type"          content="Insight Article" />
    <meta property="og:url"           content="{{ url("insight/" . $insight->slug) }}" />

    {{-- @if (file_exists(public_path() . '/' . $blog->bannerPath) && $blog->banner) --}}
    <!--
    ** LINKEDIN img requirement
        Max file size: 5 MB
        Minimum image dimensions: 1200 (w) x 627 (h) pixels
        Recommended ratio: 1.91:1
    -->
    <meta property="og:image"  content="{{ url($insight->thumbnailPath) }}" />
    {{-- @endif --}}
@endpush
