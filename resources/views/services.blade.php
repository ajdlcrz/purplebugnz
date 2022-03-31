@extends('layouts.app')

@section('content')
<x-header
    tag="Services"
    background="/storage/banners/{{ $contents->firstWhere('section', 'banner')->contents['image'] }}"
    title="{{ $contents->firstWhere('section', 'banner')->contents['heading'] }}"
    subtitle="{!! $contents->firstWhere('section', 'banner')->contents['body']  !!}"
></x-header>

<div class="c-services">
    <div class="c-services--wrapper">
        @foreach ($services as $service)
        <div class="card c-services--card">
            <img src="{{ $service->thumbnailPath }}" class="card-img-top" alt="service thumbnail">

            <div class="card-body c-servicesCard--body">
                <div>
                    <h5 class="card-title">{{ $service->title }}</h5>
                    <p class="card-text">{{ $service->strippedDescription }}</p>
                </div>

                <div class="c-serviceCard--buttons">
                    <a href="{{ url("service/{$service->slug}") }}" class="btn btn-outline-secondary">Learn More</a>
                    <a href="{{ url("service/{$service->slug}#inquire-form") }}" class="btn btn-purple">Inquire Now</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@push('seo')
<title>{{ $contents->firstWhere('section', 'seo')->contents['meta_title'] }}</title>
<meta name="description" content="{{ $contents->firstWhere('section', 'seo')->contents['meta_description'] }}">
<meta name="keywords" content="{{ $contents->firstWhere('section', 'seo')->contents['meta_keyword'] }}">
@endpush
