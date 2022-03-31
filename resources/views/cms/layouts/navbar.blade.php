<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm cms-navbar px-0">
    <div class="container-fluid">
        <button id="cms-nav-btn-toggler" class="mr-3 cms-nav-btn-toggler">
            <span class="cms-navbar-burger"></span>
        </button>

        <a class="navbar-brand" href="{{ auth()->user()->userRedirection() }}">
            <img src="{{ asset('img/purplebug-logo.svg') }}" alt="pb logo">
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        Hello, &nbsp; <span class="cms-nav-username">{{ auth()->user()->name }}!</span>

                        <span class="cms-navbar-user ml-3"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route("my-account") }}">
                            My Account
                        </a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="{{ route("help") }}" target="__blank" rel="noopener noreferrer">
                            Help
                        </a>

                        <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
