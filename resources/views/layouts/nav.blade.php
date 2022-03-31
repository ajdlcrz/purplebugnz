<nav class="navbar navbar-expand-lg navbar-light c-nav">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('img/purplebug-logo.svg') }}" width="150" alt="purplebug logo">
        </a>

        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-collapse collapse" id="navbar">
            <div class="ml-auto c-nav--linksWrap">
                <div class="c-nav--flags">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('img/flag-ph.svg') }}" height="15" alt="PH flag">
                    </a>

                    <span class="c-nav-flagDivider"></span>

                    <a href="https://purplebug.net.nz/" target="__blank" rel="noopener noreferrer">
                        <img src="{{ asset('img/flag-nz.svg') }}" height="15" alt="NZ flag">
                    </a>
                </div>

                <ul class="navbar-nav c-nav--links">
                    <li class="nav-item {{ (request()->is('/')) ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('/') }}">Home</a>
                    </li>

                    <li class="nav-item {{ (request()->is('about-us') || request()->is('our-team')) ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('about-us') }}">About Us</a>
                    </li>

                    <li class="nav-item {{ (request()->is('services*') || request()->is('service*')) ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('services') }}">Services</a>
                    </li>

                    <li class="nav-item {{ (request()->is('career*')) ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('careers') }}">Careers</a>
                    </li>

                    <li class="nav-item {{ (request()->is('blogs*') | request()->is('blog*')) ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('blogs') }}">Blogs</a>
                    </li>

                    <li class="nav-item {{ (request()->is('insights*') | request()->is('insight*')) ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('insights') }}">Insights</a>
                    </li>

                    <li class="nav-item {{ (request()->is('contact-us')) ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('contact-us') }}">Contact Us</a>
                    </li>

                    <form class="align-self-center" action="{{ url('search') }}" method="GET">
                        <div class="career-filters justify-content-center" style="min-height: 30px;">
                            <input
                                type="text"
                                name="keyword"
                                placeholder="Search PurpleBug"
                                class="job-search"
                            />
                        </div>
                    </form>
                </ul>
            </div>
        </div>
    </div>
</nav>
