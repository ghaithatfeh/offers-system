<!DOCTYPE html>
<html lang="{{ Lang::locale() }}" dir="{{ App::isLocale('ar') ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- google fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    {{-- CSS --}}
    @if (Lang::locale() == 'ar')
        <link rel="stylesheet" href="{{ asset('css/app.rtl.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @endif

    {{-- fontawesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />

    <style>
        html[lang='ar'] body {
            font-family: 'Noto Kufi Arabic', sans-serif !important;
        }

        html[lang='ar'] input {
            direction: rtl;
        }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <b>Offers Dashboard</b>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                @if (session('message'))
                    <div class="alert alert-danger">{{ session('message') }}</div>
                @endif
                <p class="login-box-msg">{{ __('Sign in to start your session') }}</p>
                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input name="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input name="password" type="password" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Password" required autocomplete="current-password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="d-flex">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember" name="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                            <p class="mb-1 d-block ms-auto">
                                <a href="forgot-password.html">{{ __('I forgot my password') }}</a>
                            </p>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary btn-block">{{ __('Sign In') }}</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>

</html>
