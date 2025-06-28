@extends('web.layouts2.app')
@section('content')

<nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Track</li>
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

                <h4>Track Your Order</h4>
                <p>Courier: {{ $tracking['shipment_track'][0]['courier_name'] }}</p>
                <p>AWB: {{ $tracking['shipment_track'][0]['awb_code'] }}</p>
                <p>Status: {{ $trackingData['shipment_status'] ?? 'Pending' }}</p>
                <a href="{{ $tracking['track_url'] }}" target="_blank">Track on Shiprocket</a>

            </div><!-- End .form-tab -->
        </div><!-- End .form-box -->
    </div><!-- End .container -->
</div><!-- End .login-page section-bg -->

@endsection
@section('javascript')
@endsection