@extends('layouts.app')

@section('content')
<header>
    <div class="homeBanner--flickity">
        <!-- Banner Image - 1533 x 873 -->
        @foreach ($contents->firstWhere('section', 'banners')->contents as $key => $banner)
        <div class="c-homeBanner carousel-cell">
            <div
                class="c-homeBanner--wrap"
                style="background-image: url({{ $contents->firstWhere('section', 'banners')->homebannerPath($banner) }})"
            >
                <img class="d-none" src="{{ asset($contents->firstWhere('section', 'banners')->homebannerPath($banner)) }}" alt="">
                <div class="c-homeBanner--inquire">
                    <h1 class="c-homeBanner--title">{{ $banner['heading'] }}</h1>
                    <div class="c-homeBanner-details">{!! $banner['body'] !!}</div>

                    @if ($banner['btn_label'])
                    <a class="btn btn-purple" href="{{ $banner['btn_link'] ?? '#' }}" target="__blank" rel="noopener noreferrer">
                        {{ $banner['btn_label'] }}
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</header>

<main class="c-home">
    <div id="ourPartners" class="c-partners">
        <div class="c-partnersDesc--wrap">
            <div class="c-partners--title">Our Partners</div>

            <div class="c-partners--details">
                {!! $contents->firstWhere('section', 'partners')->body !!}
            </div>
        </div>

        <div class="c-partners--lists">
            @foreach ($partners as $partner)
            <!-- Images- 197 x 123 -->
            <a href="{{ $partner->link }}" target="__blank" rel="noopener noreferrer">
                <img src="/storage/homepage/partners/{{ $partner->image }}" alt="{{ $partner->alt_text }}" height="123" width="197">
            </a>
            @endforeach
        </div>
    </div>

    <div class="c-services">
        <div class="c-services--title">Whatt We Offer</div>

        <div class="c-services--wrapper">
            @foreach ($services as $service)
            <a href="{{ url("service/{$service->slug}") }}" class="card c-services--card">
                <img src="{{ $service->thumbnailPath }}" class="card-img-top" alt="service thumbnail">

                <div class="card-body c-servicesCard--body">
                    <div>
                        <h5 class="card-title">{{ $service->title }}</h5>
                        <p class="card-text">{{ $service->strippedDescription }}</p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <div class="c-offers--goServices">
            <a class="btn btn-outline-purple" href="{{ url('services') }}">Go To Services</a>
        </div>
    </div>

    <!-- Background Image - 1920 x 658 -->
    <div id="whyPurplebug" class="c-why" style="background-image: url('/storage/homepage/footer/{{ $contents->firstWhere('section', 'footer_banner')->contents['image'] }}')">
        <div class="c-why__wrap">
            <h1 class="c-why__title">Why PurpleBug?</h1>

            {!! $contents->firstWhere('section', 'footer_banner')->contents['body'] !!}

            <a class="btn btn-outline-white" href="{{ $contents->firstWhere('section', 'footer_banner')->contents['link'] }}" target="__blank" rel="noopener noreferrer">
                About Us
            </a>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    const homeBanner = document.querySelector('.homeBanner--flickity');
    const flktyBanner = new Flickity( homeBanner, {
        // options
        autoPlay: 3000,
        imagesLoaded: true,
        pageDots: false,
        prevNextButtons: false,
        wrapAround: true,
    });

    const partners = document.querySelector('.c-partners--lists');
    const flkty = new Flickity( partners, {
        // options
        contain: true,
        freeScroll: true,
        wrapAround: true,
        autoPlay: 1000,
        imagesLoaded: true,
        pageDots: false,
        prevNextButtons: false,
    });
</script>
@endpush

@push('seo')
<title>{{ $contents->firstWhere('section', 'seo')->contents['meta_title'] }}</title>
<meta name="description" content="{{ $contents->firstWhere('section', 'seo')->contents['meta_description'] }}">
<meta name="keywords" content="{{ $contents->firstWhere('section', 'seo')->contents['meta_keyword'] }}">
@endpush
