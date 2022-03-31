<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="auth" content="{{ auth()->user() }}">

    <title>PurpleBug - CMS</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg" href="{{ asset('img/purplebug-icon.svg') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/cms.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/cms.css') }}" rel="stylesheet">

    {{-- scripts --}}
    @stack('scripts')
</head>
<body @guest class="cms-login" @endguest>
    <div id="cms">
        @auth
            @include('cms.layouts.navbar')
            @include('cms.layouts.sidebar')
        @endauth

        <main class="position-relative">
            @yield('content')
            <flash message="{{ session('message') }}" status="{{ session('status') ?? 'success' }}"></flash>
        </main>
    </div>
</body>
</html>
