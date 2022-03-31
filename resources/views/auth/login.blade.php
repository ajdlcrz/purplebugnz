@extends('cms.layouts.app')

@section('content')
<div>
    <div class="card">
        <div class="card-body py-5">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-5">
                    <img src="{{ asset('img/purplebug-logo.svg') }}" alt="purplebug-logo">
                </div>

                <div class="form-group text-center">
                    <input id="email" type="email" class="form-control py-4 @error('email') is-invalid @enderror" name="email" placeholder="User ID" @if(app()->environment('local')) value="admin@purplebug.net" @else value="{{ old('email') ?? '' }}" @endif required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group text-center">
                    <input id="password" type="password" class="form-control py-4 @error('password') is-invalid @enderror" name="password" placeholder="Password" @if(app()->environment('local')) value="admin123456pb" @endif required autocomplete="current-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- <div class="form-group row">
                    <div class="col-md-6 offset-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                </div> --}}

                <div class="form-group">
                    <button type="submit" class="btn btn-purple">
                        Sign in
                    </button>

                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
