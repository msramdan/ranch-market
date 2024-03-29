@extends('layouts.auth')

@section('title', __('Log in'))

@push('css')
    <link rel="stylesheet" href="{{ asset('mazer') }}/css/pages/auth.css">
@endpush

@section('content')
    <section>
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-12">
                    <div class="login-card">

                        <form class="theme-form login-form" method="POST" action="{{ route('login') }}">
                            @csrf
                            <center>
                                @if (setting_web()->logo != null)
                                    <img src="{{ Storage::url('public/img/setting_app/') . setting_web()->logo }}"
                                        alt="" style="width: 60%">
                                @endif

                                <h6>Welcome back! Log in to your account.</h6>
                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible show fade">
                                        <ul class="ms-0 mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>
                                                    <p>{{ $error }}</p>
                                                </li>
                                            @endforeach
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </ul>
                                    </div>
                                @endif
                                @if (session('status'))
                                    <div class="alert alert-success alert-dismissible show fade">
                                        {{ session('status') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                            </center>
                            <div class="form-group">
                                <label>Email Address</label>
                                <div class="input-group"><span class="input-group-text"><i class="icon-email"></i></span>
                                    <input class="form-control" type="email" name="email" required="" placeholder=""
                                        value="" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <div class="input-group"><span class="input-group-text"><i class="icon-lock"></i></span>
                                    <input class="form-control" type="password" name="password" id="password"
                                        value="" required="" placeholder="" required>
                                </div>
                            </div>
                            <div class="form-group">
                                {{-- <div class="col-md-6"> --}}
                                {!! NoCaptcha::display() !!}
                                {!! NoCaptcha::renderJs() !!}
                                {{-- @error('g-recaptcha-response')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror --}}
                                {{-- </div> --}}
                            </div>
                            <div class="form-group">
                                <div class="checkbox">
                                    <input id="checkbox1" type="checkbox" onclick="myFunction()">
                                    <label for="checkbox1">Show Password</label>
                                    {{-- </div><a class="link" href="{{ route('password.request') }}">Forgot password?</a> --}}
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-block" type="submit">Sign in</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
