@extends('layouts.app')

@section('content')
<x-header
    tag="Our Team"
    background="/storage/banners/{{ $contents->firstWhere('section', 'banner')->contents['image'] }}"
    title="{{ $contents->firstWhere('section', 'banner')->contents['heading'] }}"
    subtitle="{!! $contents->firstWhere('section', 'banner')->contents['body']  !!}"
></x-header>

<div class="c-team">
    <div class="employees">
        <div class="employee-slider">
             <!--Image - 676 Width Maximum; 561 Height Maximum -->
            @foreach ($team_photos as $photo)
            <img class="carousel-cell" src="/storage/teams/photos/{{ $photo->image }}">
            @endforeach
        </div>
    </div>

    <div id="whoWeAre" class="c-who">
        <div class="c-who--wrapper">
            <h4 class="c-who--title">Who We Are</h4>
            <p>
                {!! $contents->firstWhere('section', 'who_we_are')->body !!}
            </p>
        </div>
    </div>

    <div id="executivesList" class="c-executives">
        <div class="c-executive">
            <div class="exec-image">
                <!-- Executive Image - 630 x 688 -->
                <img
                    class="img-fluid"
                    src="/storage/teams/executives/{{ $contents->firstWhere('section', 'executives')->contents[0]['image'] }}"
                    height="630"
                    width="688"
                    alt="marlon-gonzales-image"
                >
            </div>

            <div class="c-exec--details">
                <h4 class="exec-name">{{ $contents->firstWhere('section', 'executives')->contents[0]['name'] }}</h4>
                <small class="exec-position">{{ $contents->firstWhere('section', 'executives')->contents[0]['position'] }}</small>

                <p class="exec-description">{!! $contents->firstWhere('section', 'executives')->contents[0]['body'] !!}</p>
            </div>
        </div>

        <div class="c-executive">
            <div class="c-exec--details">
                <h4 class="exec-name">{{ $contents->firstWhere('section', 'executives')->contents[1]['name'] }}</h4>
                <small class="exec-position">{{ $contents->firstWhere('section', 'executives')->contents[1]['position'] }}</small>

                <p class="exec-description">{!! $contents->firstWhere('section', 'executives')->contents[1]['body'] !!}</p>
            </div>

            <div class="exec-image">
                <!-- Executive Image - 630 x 688 -->
                <img
                    class="img-fluid"
                    src="/storage/teams/executives/{{ $contents->firstWhere('section', 'executives')->contents[1]['image'] }}"
                    height="630"
                    width="688"
                    alt="jonna-coja-image"
                >
            </div>
        </div>
    </div>

    <div class="c-our-team">
        @foreach ($team as $employee)
        <div class="card">
            <!-- Employee Image - 640 x 413 -->
            <img class="card-img-top" src="{{ $employee->imagePath }}" height="640" width="413" alt="{{ $employee->name }}-image">
            <div class="card-body">
                <h5 class="card-title">{{ $employee->name }}</h5>
                <p class="card-text">{{ $employee->position }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <div class="c-why c-join">
        <div class="c-why__wrap">
            <h1 class="c-why__title">Join Our Team</h1>
            <p>{!! $contents->firstWhere('section', 'join_our_team')->contents['body'] !!}</p>

            <a class="btn btn-outline-secondary btn-lg" href="{{ $contents->firstWhere('section', 'join_our_team')->contents['link'] }}">See Careers</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const elem = document.querySelector('.employee-slider');
    const flkty = new Flickity( elem, {
        // options
        contain: true,
        freeScroll: true,
        wrapAround: true,
        autoPlay: 2000,
        imagesLoaded: true,
        pageDots: false,
        prevNextButtons: false
    });
</script>
@endpush

@push('seo')
<title>{{ $contents->firstWhere('section', 'seo')->contents['meta_title'] }}</title>
<meta name="description" content="{{ $contents->firstWhere('section', 'seo')->contents['meta_description'] }}">
<meta name="keywords" content="{{ $contents->firstWhere('section', 'seo')->contents['meta_keyword'] }}">
@endpush