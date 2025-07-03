@extends('web.layouts2.app')
<style>
    .intro-slider-container {
        max-height: 520px;
        overflow: hidden;
    }
    .intro-slider-container,
    .intro-slide {
        background-color: transparent !important;
    }

    /* Tablet (768px – 991.98px) */
    @media (min-width: 768px) and (max-width: 991.98px) {
        .intro-slider-container {
            max-height: 319px;
        }
    }
    /* Medium Phones (481px – 767.98px) */
    @media (min-width: 481px) and (max-width: 767.98px) {
        .intro-slider-container {
            max-height: 400px;
        }
    }
    /* Small Phones (≤480px) */
    @media (max-width: 480px) {
        .intro-slider-container {
            max-height: 360px;
        }
    }
    @media (min-width: 530px) and (max-width: 550px) {
        .intro-slider-container {
            max-height: 320px !important;
        }
    }
    /* Large Tablets and Small Laptops (1024px – 1199.98px) */
    @media (min-width: 1024px) and (max-width: 1199.98px) {
        .intro-slider-container {
            max-height: 360px;
            /* or your preferred height */
        }
    }

    /* === Default (Desktop and Large Screens) === */
    .owl-simple.owl-nav-inside .owl-dots {
        position: absolute;
        bottom: 12pc !important;
        left: 0;
        right: 0;
        display: flex !important;
        justify-content: center;
    }

    .owl-simple .owl-nav [class*='owl-'] {
        position: absolute;
        top: 37% !important;
        transform: translateY(-50%);
    }

    /* === Tablet (iPad Air: 768px–991.98px) === */
    @media (min-width: 768px) and (max-width: 900px) {
        .owl-simple.owl-nav-inside .owl-dots {
            bottom: 9pc !important;
        }
        .owl-simple .owl-nav [class*='owl-'] {
            top: 40% !important;
        }
    }
    @media (min-width: 912px) and (max-width: 991.98px) {
        .owl-simple.owl-nav-inside .owl-dots {
            bottom: 10pc !important;
        }
    }
    /* === Mobile (up to 767.98px) === */
    @media (max-width: 767.98px) {
        .owl-simple.owl-nav-inside .owl-dots {
            bottom: 3pc !important;
        }
        .owl-simple .owl-nav [class*='owl-'] {
            top: 45% !important;
        }
    }
    @media (min-width: 481px) and (max-width: 767.98px) {
        /* @media (min-width: 481px) and (max-width: 766.98px) { */
        .owl-simple.owl-nav-inside .owl-dots {
            bottom: 6pc !important;
            /* Adjust based on your layout */
        }
        .owl-simple .owl-nav [class*='owl-'] {
            top: 42% !important;
        }
    }
    @media (max-width: 359.98px) {
        .owl-simple.owl-nav-inside .owl-dots {
            bottom: 2pc !important;
            /* 2pc = 32px */
        }
        .owl-simple .owl-nav [class*='owl-'] {
            top: 47% !important;
        }
    }
</style>

@section('content')
<div class="intro-section bg-lighter pt-5 pb-3">
    <div class="container">
        <div class="row">

            <div class="col-lg-12">
                <div class="intro-slider-container slider-container-ratio slider-container-1 mb-2 mb-lg-0">

                    <!-- <div class="intro-slider intro-slider-1 owl-carousel owl-simple owl-light owl-nav-inside"
                        data-toggle="owl" data-owl-options='{
                                        "nav": false, 
                                        "responsive": {
                                            "768": {
                                                "nav": true
                                            }
                                        }
                                    }'> -->

                    <!--  AUTO PLAY SLIDER -->
                    <div class="intro-slider intro-slider-1 owl-carousel owl-simple owl-light owl-nav-inside"
                        data-toggle="owl" data-owl-options='{
                                "nav": false,
                                "autoplay": true,
                                "autoplayTimeout": 3000,
                                "autoplayHoverPause": true,
                                "responsive": {
                                    "768": {
                                        "nav": true
                                    }
                                }
                            }'>

                        <div class="intro-slide">
                            <a href="{{ url('more-products') }}">
                                <figure class="slide-image">
                                    <picture>
                                        <source media="(max-width: 480px)" srcset="{{ asset('public/assets/images/slider/slide-1-480w.webp') }}">
                                        <img src="{{ asset('public/assets/images/slider/slide-1.webp') }}" alt="Image Desc">
                                    </picture>
                                </figure>
                            </a>
                        </div>

                        <div class="intro-slide">
                            <a href="{{ url('more-products') }}">
                                <figure class="slide-image">
                                    <picture>
                                        <source media="(max-width: 480px)" srcset="{{ asset('public/assets/images/slider/slide-2-480w.webp') }}">
                                        <img src="{{ asset('public/assets/images/slider/slide-2.webp') }}" alt="Image Desc">
                                    </picture>
                                </figure>
                            </a>
                        </div>

                        <div class="intro-slide">
                            <a href="{{ url('more-products') }}">
                                <figure class="slide-image">
                                    <picture>
                                        <source media="(max-width: 480px)" srcset="{{ asset('public/assets/images/slider/slide-3-480w.webp') }}">
                                        <img src="{{ asset('public/assets/images/slider/slide-3.webp') }}" alt="Image Desc">
                                    </picture>
                                </figure>
                            </a>
                        </div>
                    </div>

                    <span class="slider-loader"></span>
                </div>
            </div>            
        </div> <!-- End .row -->

        <div class="mb-3"></div><!-- End .mb-6 -->

        <div class="owl-carousel owl-simple" data-toggle="owl" data-owl-options='{
            "nav": false, 
            "dots": false,
            "margin": 30,
            "loop": false,
            "responsive": {
                "0": {"items": 2},
                "420": {"items": 3},
                "600": {"items": 4},
                "900": {"items": 5},
                "1024": {"items": 6}
            }
        }'>

        @foreach ($data['brands'] as $brand)
        <a href="#" class="brand">
            <img src="{{ asset('public/assets/images/brands/' . $brand->logo) }}" alt="{{ $brand->name }}">
        </a>
        @endforeach
    </div><!-- End .owl-carousel -->
    </div>
</div>

<!-- Hidden on mobile (visible on md and up) -->
<div class="mb-6 d-none d-md-block"></div>
<div class="mb-5 d-none d-md-block"></div>

<!-- Visible only on mobile -->
<div class="mb-3 d-block d-md-none"></div>

<div class="container">

    <div class="heading heading-center mb-6">
        <h2 class="title">Recent Arrivals</h2>
        <ul class="nav nav-pills nav-border-anim justify-content-center" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="top-all-link" data-toggle="tab" href="#top-all-tab" role="tab"
                    aria-controls="top-all-tab" aria-selected="true">All</a>
            </li>
            @foreach ($data['categories'] as $category)
            <li class="nav-item">
                <a class="nav-link" id="top-{{ $category->id }}-link" data-toggle="tab"
                    href="#top-{{ $category->id }}-tab" role="tab" aria-controls="top-{{ $category->id }}-tab"
                    aria-selected="false">{{ $category->name }}</a>
            </li>
            @endforeach
        </ul>
    </div>
    <!-- End .heading -->

    <div class="tab-content">
        <!-- All Products Tab -->
        <div class="tab-pane fade show active" id="top-all-tab" role="tabpanel" aria-labelledby="top-all-link">
            <div class="row justify-content-center">
                @foreach ($data['all_products'] as $product)
                    @include('web.partials.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>

        <!-- Category Specific Tabs -->
        @foreach ($data['categories'] as $category)
        <div class="tab-pane fade" id="top-{{ $category->id }}-tab" role="tabpanel" aria-labelledby="top-{{ $category->id }}-link">
            <div class="row justify-content-center">
                @foreach ($category->products as $product)
                    @include('web.partials.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
    <!-- .End .tab-pane -->

</div><!-- End .tab-content -->

{{-- <div class="container">
    <div class="heading heading-center mb-6">
        <h2 class="title">Recently arrived</h2>
    </div>
    <!-- End .heading -->
    <div class="tab-content">
        <!-- All Products Tab -->
        <div class="tab-pane fade show active" id="top-all-tab" role="tabpanel" aria-labelledby="top-all-link">
            <div class="row justify-content-center g-4">
                @foreach ($data['all_products'] as $product)
                @include('web.partials.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>
    </div>
    <!-- .End .tab-pane -->
</div><!-- End .tab-content --> --}}

<!-- @if(count($data['all_products']) == 4)
<div class="more-container text-center">
    <a href="{{ route('product.more') }}" class="btn btn-outline-darker btn-more"><span>Load more products</span><i class="icon-long-arrow-down"></i></a>
</div>
@endif -->

<div class="container">
    <hr>
    <div class="row justify-content-center">
        <div class="col-lg-4 col-sm-6">
            <div class="icon-box icon-box-card text-center">
                <span class="icon-box-icon">
                    <i class="icon-rocket"></i>
                </span>
                <div class="icon-box-content">
                    <h3 class="icon-box-title">Payment & Delivery</h3>
                    <p>Free shipping for orders over $50</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-sm-6">
            <div class="icon-box icon-box-card text-center">
                <span class="icon-box-icon">
                    <i class="icon-rotate-left"></i>
                </span>
                <div class="icon-box-content">
                    <h3 class="icon-box-title">Return & Refund</h3>
                    <p>Free 100% money back guarantee</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-sm-6">
            <div class="icon-box icon-box-card text-center">
                <span class="icon-box-icon">
                    <i class="icon-life-ring"></i>
                </span>
                <div class="icon-box-content">
                    <h3 class="icon-box-title">Quality Support</h3>
                    <p>Alway online feedback 24/7</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-2"></div><!-- End .mb-2 -->
</div>
@endsection
@section('javascript')
@endsection