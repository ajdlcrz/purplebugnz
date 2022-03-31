@extends('layouts.app')

@section('content')
<x-header
    tag="Blogs"
    background="/storage/banners/{{ $contents->firstWhere('section', 'banner')->contents['image'] }}"
    title="{{ $contents->firstWhere('section', 'banner')->contents['heading'] }}"
    subtitle="{!! $contents->firstWhere('section', 'banner')->contents['body']  !!}"
></x-header>

<div class="c-blogs">
    <div class="c-blogs-latest">
        <h4>Latest</h4>

        <div class="c-blog">
            <div class="c-blog--img">
                <img src="{{ url($latest->bannerPath) }}" alt="{{ $latest->alt_text }}">
            </div>

            <div class="c-blog--body">
                <div>
                    <span class="c-blog--tag">
                        {{ $latest->category->title }}
                    </span>

                    <p class="c-blog--title c-title-blog">{{ $latest->title }}</p>
                    <p>{!! strip_tags(Str::limit($latest->details, 130)) !!}</p>
                </div>

                <div class="c-blog--body-bottom">
                    <span>{{ $latest->published_at }}</span>

                    <a class="btn btn-outline-secondary ml-auto" href="{{ url("blog/{$latest->slug}") }}">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </div>

    <recent-blogs page-name="landing"></recent-blogs>
</div>
@endsection

@push('seo')
<title>{{ $contents->firstWhere('section', 'seo')->contents['meta_title'] }}</title>
<meta name="description" content="{{ $contents->firstWhere('section', 'seo')->contents['meta_description'] }}">
<meta name="keywords" content="{{ $contents->firstWhere('section', 'seo')->contents['meta_keyword'] }}">
@endpush
