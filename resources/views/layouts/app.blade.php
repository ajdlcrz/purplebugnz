<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- SEO Meta tags -->
    @stack('seo')
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Title -->
    <title>{{ config('app.name', "PurpleBug") }}</title>
    <!-- Favicon -->
    <link rel="icon" type="image/svg" href="{{ asset('img/purplebug-icon.svg') }}">

    <!-- flickity-styles -->
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">

    <!-- fonts -->
    <link rel="preload" href="{{ asset('fonts/Gotham-Bold.otf') }}" as="font" type="font/otf" crossorigin>
    <link rel="preload" href="{{ asset('fonts/Gotham-Medium.otf') }}" as="font" type="font/otf" crossorigin>
    <link rel="preload" href="{{ asset('fonts/Gotham-Book.otf') }}" as="font" type="font/otf" crossorigin>
    <link rel="preload" href="{{ asset('fonts/Gotham-Light.otf') }}" as="font" type="font/otf" crossorigin>
    <link rel="preload" href="{{ asset('fonts/Gotham-Thin.otf') }}" as="font" type="font/otf" crossorigin>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')

    <!-- Google Tag Manager -->
    <script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-5CMN6KP');
    </script>
    <!-- End Google Tag Manager -->

    <!-- Google Search Console -->
    <meta name="google-site-verification" content="7d3dbcc92ec59237" />

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-75730843-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-75730843-2');
    </script>

    <!-- Google Recaptcha v3 -->
    <meta name="grecaptcha_sitekey" content="{{ config('services.recaptcha.site_key') }}">
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>

    <!-- Organization: -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "Purplebug Inc",
        "url": "https://purplebug.net/",
        "logo": "https://purplebug.net/img/purplebug-logo.svg",
        "sameAs": [
            "https://www.facebook.com/purplebuginc/",
            "https://www.linkedin.com/company/purplebug-inc"
        ]
    }
    </script>

    <!-- Local Business: -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "LocalBusiness",
        "name": "PurpleBug Inc",
        "image": "https://purplebug.net/img/purplebug-logo.svg",
        "@id": "https://purplebug.net/img/purplebug-logo.svg",
        "url": "https://purplebug.net/",
        "telephone": "(02) 8-551-0986",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Valero St., Salcedo Village",
            "addressLocality": "Makati City",
            "postalCode": "1226",
            "addressCountry": "PH"
        },
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": 14.5584008,
            "longitude": 121.0224319
        } ,
        "sameAs": [
            "https://www.facebook.com/purplebuginc/",
            "https://www.linkedin.com/company/purplebug-inc"
        ]
    }
    </script>
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5CMN6KP" height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->

    <div id="app">
        @include('layouts.nav')
        @yield('content')
        <flash message="{{ session('message') }}" status="{{ session('status') }}"></flash>
        @include('layouts.footer')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- flickity-scripts -->
    <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
    @stack('scripts')
</body>

</html>
