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
        <a class="breadcrumb-link" href="{{ url('careers') }}">Careers</a>
        <a class="breadcrumb-link" href="{{ url("career/{$career->slug}") }}">{{ $career->title }}</a>
    </div>

    <div class="career-apply">
        <h4 class="career-apply-label">Application Form</h4>

        <career-form
            :position="{{ $career }}"
            :careers="{{ \App\Career::get(['title', 'slug']) }}"
        ></career-form>
    </div>
</div>
@endsection