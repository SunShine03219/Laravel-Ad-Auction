@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0">
        <div class="row m-auto">
            <div class="col-md-6 p-0 login-bg">
                <img class="login-img" src="{{ asset('assets/img/login-bg.png') }}" alt="">
            </div>
            <div class="col-md-6 p-0">
                <div class="login-form">
                    <div class="heading">
                        Login
                    </div>

                    <span class="text-small">New to Coco local? <a href="#">Register now</a></span>

                    <div class="body">
                        @include('admin.flash_msg')

                        <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-12">Email</label>

                                <div class="col-md-12">
                                    <input id="email" type="email" class="form-control" name="email"
                                        value="{{ old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-12">Password</label>

                                <div class="col-md-12">
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <a class="forgot-password" href="{{ route('password.request') }}">
                                Forgot Your Password?
                            </a>

                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="checkbox">
                                        <label class="remember-me">
                                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                            Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>

                            {{-- @if (get_option('enable_recaptcha_login') == 1) --}}
                            <div class="form-group {{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                                <div class="col-md-6">
                                    <div class="g-recaptcha" data-sitekey="{{ get_option('recaptcha_site_key') }}">
                                    </div>
                                    @if ($errors->has('g-recaptcha-response'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            {{-- @endif --}}

                            <div class="form-group">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-login">
                                        Login
                                    </button>
                                </div>
                            </div>

                            <a class="btn btn-link btn-trouble" href="#">
                                Having trouble logging in?
                            </a>

                            <div class="text-small t-and-c">
                                This site is protected by reCAPTCHA and the Google <a href="#">Privacy Policy</a> and <a href="#">Terms of Service</a>
                                apply.
                            </div>
                        </form>

                        @include('auth.social_login')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
    {{-- @if (get_option('enable_recaptcha_login') == 1) --}}
    <script src='https://www.google.com/recaptcha/api.js'></script>
    {{-- @endif --}}
@endsection
