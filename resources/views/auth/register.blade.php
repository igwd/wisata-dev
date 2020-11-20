@extends('site.template')
@section('navbar')
    @include('site.navbar')
@endsection
@section('content')
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div id="card-content">
            <div id="card-title">
                <h2>{{ __('Register') }}</h2>
                <div class="underline-title"></div>
            </div>
            <div class="form">
                <form method="POST" action="{{ route('register') }}">
                @csrf
                    <div class="col-md-12">
                        <label for="name" style="padding-top:13px">{{ __('Name') }}</label>
                        <input id="name" type="text" class="form-content @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        <div class="form-border"></div>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
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
                    <div class="col-md-12">
                        <label for="password-confirm" style="padding-top:13px">{{ __('Confirm Password') }}</label>
                        <input id="password-confirm" type="password" class="form-content" name="password_confirmation" required autocomplete="new-password">
                        <div class="form-border"></div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" style="margin-top: 20px;" class="btn btn-flat btn-primary">
                            {{ __('Register') }}
                        </button>
                    </div>
                    @if (Route::has('login'))
                        <a class="btn btn-link" href="{{ route('login') }}">
                            <legend id="forgot-pass">{{ __('Already have an account?') }}</legend>
                        </a>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
