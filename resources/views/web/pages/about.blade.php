@extends('web.layouts2.app')
@section('content')

<div class="page-header text-center" style="background-image: url('{{ asset('public/assets/images/page-header-bg.jpg') }}');">
    <div class="container">
        <h1 class="page-title">About Us<span></span></h1>
    </div>
</div><!-- End .page-header -->
<nav aria-label="breadcrumb" class="breadcrumb-nav">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('more-products') }}">Shop</a></li>
            <li class="breadcrumb-item active" aria-current="page">About</li>
        </ol>
    </div>
</nav><!-- End .breadcrumb-nav -->

<div class="page-content">
    <div class="container">
        <!-- <h2 class="title">About Us</h2> -->

        <p>Reach Gems managed by Softice Technology. Reach Gems is a symbol of timeless elegance and craftsmanship. We are a premium luxury watch manufacturer
            dedicated to creating timepieces that embody sophistication, precision, and enduring beauty. Every watch we
            craft is a reflection of our passion for horology and commitment to excellence.</p>

        <br>
        <p>At Reach Gems, we believe that true luxury lies in authenticity and attention to detail. That’s why each of our
            exquisite timepieces is adorned with 100% original Moissanite diamonds, offering unrivaled brilliance and
            fire. Known for their remarkable durability and captivating sparkle, Moissanite diamonds perfectly
            complement our meticulously designed watches.</p>
        <br>
        <p>Our collections are crafted for those who appreciate refined elegance and distinctive style. From bold
            statement pieces to timeless classics, every Reach Gems watch is designed to elevate your presence and leave a
            lasting impression.</p>
        <br>
        <p>Driven by innovation and rooted in tradition, we combine advanced watchmaking technology with masterful
            artistry to deliver unmatched quality and performance. With Reach Gems, you don’t just wear a watch you wear a
            masterpiece.</p>
        <br>
        <p>Rediscover time, reimagine luxury, and rise with Reach Gems.</p>

    </div>
</div><!-- End .page-content -->

@endsection
@section('javascript')
@endsection