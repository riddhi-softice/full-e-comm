@extends('web.layouts2.app')
@section('content')

<nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Login</li>
        </ol>
    </div><!-- End .container -->
</nav><!-- End .breadcrumb-nav -->

<div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17"
     style="background-image: url('{{ asset('public/assets/images/backgrounds/login-bg.jpg') }}');">

    <div class="container">
        <div class="form-box">
            <div class="form-tab">

                @php
                    $registerHasError = $errors->any();
                @endphp

                <ul class="nav nav-pills nav-fill" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link {{ !$registerHasError ? 'active' : '' }}" id="signin-tab" data-toggle="tab" href="#signin" role="tab"
                            aria-controls="signin" aria-selected="{{ !$registerHasError ? 'true' : 'false' }}">Sign In</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $registerHasError ? 'active' : '' }}" id="register-tab" data-toggle="tab" href="#register" role="tab"
                            aria-controls="register" aria-selected="{{ $registerHasError ? 'true' : 'false' }}">Register</a>
                    </li>
                </ul>

                <!-- <ul class="nav nav-pills nav-fill" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="signin-tab" data-toggle="tab" href="#signin" role="tab"
                            aria-controls="signin" aria-selected="true">Sign In</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="register-tab" data-toggle="tab" href="#register" role="tab"
                            aria-controls="register" aria-selected="false">Register</a>
                    </li>
                </ul> -->
                <div class="tab-content">
                   
                    <!-- <div class="tab-pane fade show active" id="signin" role="tabpanel" aria-labelledby="signin-tab"> -->
                    <div class="tab-pane fade {{ !$registerHasError ? 'show active' : '' }}" id="signin" role="tabpanel" aria-labelledby="signin-tab">
                        <form action="{{ route('user.login') }}" method="POST">
                            @csrf

                            @if(session('login-error'))
                                <div class="alert alert-danger">
                                    {{ session('login-error') }}
                                </div>
                            @endif

                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                                
                            <div class="form-group">
                                <label for="singin-email"> Email address *</label>
                                <input type="email" class="form-control" id="singin-email" name="email" value="{{ old('email') }}" required>
                            </div><!-- End .form-group -->

                            <div class="form-group">
                                <label for="singin-password">Password *</label>
                                <input type="password" class="form-control" id="singin-password" name="password" required>
                            </div><!-- End .form-group -->

                            <div class="form-footer">
                                <button type="submit" class="btn btn-outline-primary-2">
                                    <span>LOG IN</span>
                                    <i class="icon-long-arrow-right"></i>
                                </button>

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="signin-remember">
                                    <label class="custom-control-label" for="signin-remember">Remember
                                        Me</label>
                                </div><!-- End .custom-checkbox -->

                                <a href="#" class="forgot-link">Forgot Your Password?</a>
                            </div><!-- End .form-footer -->
                        </form>
                        
                    </div><!-- .End .tab-pane -->

                    <!-- <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab"> -->
                    <div class="tab-pane fade {{ $registerHasError ? 'show active' : '' }}" id="register" role="tabpanel" aria-labelledby="register-tab">
                        <form action="{{ route('user.register') }}" method="POST">
                            @csrf

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="register-email">Your email address *</label>
                                <input type="email" class="form-control" id="register-email"
                                    name="email" value="{{ old('email') }}" required>
                            </div><!-- End .form-group -->

                            <div class="form-group">
                                <label for="register-password">Password *</label>
                                <input type="password" class="form-control" id="register-password"
                                    name="password" required>
                            </div><!-- End .form-group -->

                            <div class="form-footer">
                                <button type="submit" class="btn btn-outline-primary-2">
                                    <span>SIGN UP</span>
                                    <i class="icon-long-arrow-right"></i>
                                </button>

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="register-policy"
                                        required>
                                    <label class="custom-control-label" for="register-policy">I agree to the
                                        <a href="{{ url('terms-and-conditions') }}">Terms & Conditions</a> *</label>
                                </div><!-- End .custom-checkbox -->
                            </div><!-- End .form-footer -->
                        </form>
                        
                    </div><!-- .End .tab-pane -->

                </div><!-- End .tab-content -->
            </div><!-- End .form-tab -->
        </div><!-- End .form-box -->
    </div><!-- End .container -->
</div><!-- End .login-page section-bg -->

@endsection
@section('javascript')
@endsection