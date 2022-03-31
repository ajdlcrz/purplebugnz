@extends('layouts.app')

@section('content')
<x-header
    tag="Careers"
    background="/storage/banners/{{ $contents->firstWhere('section', 'banner')->contents['image'] }}"
    title="{{ $contents->firstWhere('section', 'banner')->contents['heading'] }}"
    subtitle="{!! $contents->firstWhere('section', 'banner')->contents['body']  !!}"
></x-header>

<careers></careers>
@endsection

@push('seo')
<title>{{ $contents->firstWhere('section', 'seo')->contents['meta_title'] }}</title>
<meta name="description" content="{{ $contents->firstWhere('section', 'seo')->contents['meta_description'] }}">
<meta name="keywords" content="{{ $contents->firstWhere('section', 'seo')->contents['meta_keyword'] }}">
@endpush