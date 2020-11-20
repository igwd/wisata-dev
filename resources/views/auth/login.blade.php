@extends('site.template')
@section('navbar')
    @include('site.navbar')
@endsection
@section('content')
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div id="card-content">
            <div id="card-title">
                <h2>{{ __('Login') }}</h2>
                <div class="underline-title"></div>
            </div>
            <div class="row">
                <form method="POST" class="form" action="{{ route('login') }}">
                    @csrf
                    <div class="col-md-12">
                        <label style="padding-top:13px" for="email">{{ __('E-Mail Address') }}</label>
                        <input id="email" type="email" class="form-content @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        <div class="form-border"></div>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label style="padding-top:22px" for="password">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-content @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        <div class="form-border"></div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            <legend id="forgot-pass">{{ __('Forgot Your Password?') }}</legend>
                        </a>
                    @endif
                    <div class="col-md-12">
                        <!-- <div class="container-login">
                            <div class="center-login">
                            </div>
                        </div> -->
                    </div>
                    <button id="submit-btn" type="submit">
                        {{ __('Login') }}
                    </button>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" id="signup">Don't have account yet?</a>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
