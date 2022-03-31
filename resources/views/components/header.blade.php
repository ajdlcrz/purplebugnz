<header>
    <!-- Banner Image - 1920 x 614 -->
    <div class="c-banner" style="background-image: url('{{ asset($background ?? '/img/placeholders/banner.png') }}')">
        <img class="d-none" src="{{ asset($background) }}" alt="">
        <div class="c-bannerWrap py-5">
            <span class="c-banner--tag">{{ $tag ?? 'Tag' }}</span>
            <!-- Contact Us Page p tag only -->
            @if (Request::segment(1) == 'contact-us')
                <p class="c-banner--title">{{ $title ?? 'Title' }}</p>
            @else
                <h1 class="c-banner--title">{{ $title ?? 'Title' }}</h1>
            @endif
            <div class="c-banner--subtitle">{!! $subtitle ?? 'Subtitle' !!}</div>
        </div>
    </div>
</header>
