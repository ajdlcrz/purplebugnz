<footer id="subscribeForm"  class="c-footer">
    <div class="c-footer-items">
        <div class="c-footer-pagesLink">
            <ul>
                @foreach (\App\FooterLink::get() as $footer_link)
                <li>
                    <a href="{{ url($footer_link->url) }}">{{ $footer_link->title }}</a>
                </li>
                @endforeach
            </ul>
        </div>

        <div class="c-footer-policy">
            <ul>
                <li><a href="{{ url('privacy-policy') }}" target="__blank" rel="noopener noreferrer">Privacy Policy</a></li>
                <li><a href="{{ url('terms-and-conditions') }}" target="__blank" rel="noopener noreferrer">Terms & Conditions</a></li>
            </ul>
            <br>

            <span>Follow Us</span>
            <div class="c-footer-social">
                <a href="https://www.facebook.com/purplebuginc/" target="__blank" rel="noopener noreferrer">
                    <img src="{{ url("img/icon-fb.svg") }}" alt="fb icon">
                </a>
                <a href="https://www.linkedin.com/company/purplebug-inc" target="__blank" rel="noopener noreferrer">
                    <img src="{{ url("img/icon-linkedin.svg") }}" alt="linkedin icon">
                </a>
            </div>
        </div>

        <div class="c-footer-subscribe">
            <span>Subscribe to Our Newsletter</span>
            <p>
                Sign up for our newsletter to get the latest news, updates, and trending content delivered fresh to your inbox.
            </p>

            <form class="c-footer--form" action="{{ url('subscribe#subscribeForm') }}" method="post">
                @csrf

                <input type="hidden" name="recaptcha" id="recaptcha">

                <input name="email" type="email" placeholder="Type your email here">

                <button type="submit" class="btn btn-purple">Subscribe</button>
            </form>

            @error('email')
            <small class="text-danger">{{ $message }}</small>
            @enderror

            @error('recaptcha')
            <br>
            <small class="text-danger">Please try again</small>
            @enderror

            @if ($msg = session('subscribe-success'))
            <small class="text-success">{{ $msg }}</small>
            @endif

        </div>

        <div class="c-footer-certifications">
            <h6>This Website is Certified</h6>

            <div class="c-footer-certifications__surly">
                <link href="https://cdn.sur.ly/widget-awards/css/surly-badges.min.css" rel="stylesheet" />
                <div id="surly-badge" class="mx-auto surly-badge_white-gradient surly__id_64638585" style="max-width: 110px;" onclick="if(event.target.nodeName.toLowerCase() != 'a' && event.target.parentElement.nodeName.toLowerCase() != 'a') {window.open('https://sur.ly/i/purplebug.net'); return 0;}">
                    <div class="surly-badge__header" style="padding-top: 8px !important;">
                        <h3 class="surly-badge__header-title" style="font-size: 9px !important; margin-bottom: 0 !important;">Web Safety</h3>
                        <p class="surly-badge__header-text" style="font-size: 28px !important; margin-bottom: 0 !important;">BOSS</p>
                    </div>

                    <div class="surly-badge__tag" style="min-width: 142px; max-height: 18px;">
                        <a class="surly-badge__tag-text" href="https://sur.ly/i/purplebug.net">purplebug.net</a>
                    </div>

                    <div class="surly-badge__footer">
                        <h3 class="surly-badge__footer-title" style="font-size: 12px !important;">Free of toxic links</h3>
                        <p class="surly-badge__footer-text" style="font-size: 12px !important;">Approved by <a href="https://sur.ly" class="surly-badge__footer-link">Sur.ly</a></p>
                    </div>

                    <div class="surly-badge__date" style="display: block !important;">2022</div>
                </div>
            </div>
        </div>
    </div>

    <div class="c-footer--cookie">
        <a href="{{ url('/') }}">
            <img src="{{ url("img/purplebug-icon.svg") }}" alt="" style="max-height: 59px">
        </a>

        <span class="pb--tagline">
            We Think And Talk Digital.
        </span>

        <p class="text-center mx-auto pb--cookie">
            We use cookies to ensure you get the best experience while browsing the site.
            By continued use, you agree to our
            <a href="{{ url('privacy-policy') }}" target="__blank" rel="noopener noreferrer">privacy policy</a>
            and accept our use of such cookies. For further information,
            <a href="{{ url('terms-and-conditions') }}" target="__blank" rel="noopener noreferrer">click here.</a>
            <br>
            <span>Copyright © {{ date('Y') }} PurpleBug Inc. All Rights Reserved.</span>
        </p>
    </div>
</footer>

@push('scripts')
<script>
    grecaptcha.ready(() => {
        grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', { action: 'subscribe' })
            .then((token) => token ? document.getElementById('recaptcha').value = token : '');
    });
</script>
@endpush
