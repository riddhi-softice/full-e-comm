@extends('web.layouts2.app')
@section('content')

<div class="page-header text-center"
    style="background-image: url('{{ asset('public/assets/images/page-header-bg.jpg') }}');">
    <div class="container">
        <h1 class="page-title">Contact Us<span></span></h1>
    </div><!-- End .container -->
</div><!-- End .page-header -->
<nav aria-label="breadcrumb" class="breadcrumb-nav">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('more-products') }}">Shop</a></li>
            <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
        </ol>
    </div><!-- End .container -->
</nav><!-- End .breadcrumb-nav -->

<div class="page-content">
    <div class="container">
        <h2 class="title">Contact Us</h2>

        <!-- <h1 class="title">Customer Support & Inquiries</h1> -->
        <p>For orders, product details, or any assistance, feel free to reach out to us. Our team is always here to help you.</p>
        <!-- <p>WhatsApp: <a href="https://wa.me/917016126901?text=Hello">+91 7016126901</a></p>
        <p> Email: <a href="#">reachgemsandjewellery@gmail.com</a></p> -->

        <p><strong>Business Name:</strong> Reach Gems managed by Softice Technology</p>
        <p><strong>Phone:</strong> <a href="https://wa.me/917016126901?text=Hello">+91 7016126901</a></p>
        <p><strong>Email:</strong> <a href="#"> reachgemsandjewellery@gmail.com</a></p>
        <p><strong>Address:</strong> JAY BALAJI ESTATE-C, Vasta Devdi Rd, Tunki, Katargam, Surat, Gujarat 395003, India</p>

    </div><!-- End .container -->
</div><!-- End .page-content -->

@endsection
@section('javascript')
@endsection