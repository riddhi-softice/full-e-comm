@extends('web.layouts2.app')

@section('content')
<nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
    <div class="container d-flex align-items-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('more-products') }}">Products</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </div><!-- End .container -->
</nav><!-- End .breadcrumb-nav -->

<div class="page-content">
    <div class="container">
        <div class="product-details-top">
            <div class="row">

                <div class="col-md-6">
                    <div class="product-gallery product-gallery-vertical">
                        <div class="row">

                            {{-- MAIN IMAGE --}}
                            @php
                                $primaryImage = $product->images->firstWhere('is_primary', 1) ?? $product->images->first();
                            @endphp

                            @if ($primaryImage)
                            <figure class="product-main-image">
                                <img id="product-zoom"
                                    src="{{ asset('public/assets/images/demos/demo-2/products/' . $primaryImage->path) }}"
                                    data-zoom-image="{{ asset('public/assets/images/demos/demo-2/products/' . $primaryImage->path) }}"
                                    alt="Main product image">

                                <a href="#" id="btn-product-gallery" class="btn-product-gallery">
                                    <i class="icon-arrows"></i>
                                </a>
                            </figure>
                            @endif

                            {{-- GALLERY --}}
                            <div id="product-zoom-gallery" class="product-image-gallery">
                                @foreach ($product->images as $image)
                                <a class="product-gallery-item {{ $loop->first ? 'active' : '' }}" href="#"
                                    data-image="{{ asset('public/assets/images/demos/demo-2/products/' . $image->path) }}"
                                    data-zoom-image="{{ asset('public/assets/images/demos/demo-2/products/' . $image->path) }}">
                                    <img src="{{ asset('public/assets/images/demos/demo-2/products/' . $image->path) }}"
                                        alt="product image">
                                </a>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="product-details">
                        <h1 class="product-title">{{ $product->name }}</h1>

                        <div class="product-price">
                            <span style="text-decoration: line-through;">
                                <!-- MRP : ${{ number_format($product->reseller_price) }} -->
                                @if(strtolower($country) === 'india')
                                    MRP : ₹{{ $product->reseller_display_price }}
                                @else
                                    MRP : ${{ number_format($product->reseller_display_price, 2) }}
                                @endif
                            </span>
                        </div>
                        <div class="product-price">
                            <span style="color: red;">
                                <!-- SALE PRICE : ${{ number_format($product->price) }} -->
                                @if(strtolower($country) === 'india')
                                    SALE PRICE : ₹{{ $product->display_price }}
                                @else
                                    SALE PRICE : ${{ number_format($product->display_price, 2) }}
                                @endif
                            </span>
                        </div>
                        <div class="product-content">
                            <p>{{ $product->description }}</p>
                        </div>

                        @php
                            $whatsappNumber = '917016126901';
                            $productName = $product->name;
                            $message = "Hello, I am interested in this product:\n\n$productName";
                        @endphp

                        <div class="product-details-action">
                            <a href="{{ route('order.add', $product->id) }}" class="btn-product btn-cart"><span>Order Now</span></a>
                            <!-- <button id="razorpay-button" class="btn-product btn-cart" style="background: transparent;">Order Now </button> -->
                            <!-- <a href="https://wa.me/{{ $whatsappNumber }}?text={{ urlencode($message) }}" class="btn-product btn-cart"><span>Order Now</span></a> -->
                        </div><!-- End .product-details-action -->

                        <div class="product-details-footer">
                            <div class="social-icons social-icons-sm">
                                <span class="social-label">Share:</span>
                                <a href="#" class="social-icon" title="Facebook" target="_blank"><i
                                        class="icon-facebook-f"></i></a>
                                <!-- <a href="#" class="social-icon" title="Twitter" target="_blank"><i
                                        class="icon-twitter"></i></a> -->
                                <a href="#" class="social-icon" title="Instagram" target="_blank"><i
                                        class="icon-instagram"></i></a>
                                <!-- <a href="#" class="social-icon" title="Pinterest" target="_blank"><i
                                        class="icon-pinterest"></i></a> -->
                            </div>
                        </div><!-- End .product-details-footer -->

                    </div><!-- End .product-details -->
                </div><!-- End .col-md-6 -->

            </div><!-- End .row -->
        </div><!-- End .product-details-top -->

        <div class="product-details-tab">
            <ul class="nav nav-pills justify-content-center" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="product-desc-link" data-toggle="tab" href="#product-desc-tab"
                        role="tab" aria-controls="product-desc-tab" aria-selected="true">Description</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" id="product-info-link" data-toggle="tab" href="#product-info-tab" role="tab"
                        aria-controls="product-info-tab" aria-selected="false">Additional
                        information</a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link" id="product-shipping-link" data-toggle="tab" href="#product-shipping-tab"
                        role="tab" aria-controls="product-shipping-tab" aria-selected="false">Shipping & Returns</a>
                </li>

            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="product-desc-tab" role="tabpanel"
                    aria-labelledby="product-desc-link">
                    <div class="product-desc-content">
                        {!! $product->long_desc !!}
                    </div><!-- End .product-desc-content -->
                </div><!-- .End .tab-pane -->
                <!-- <div class="tab-pane fade" id="product-info-tab" role="tabpanel" aria-labelledby="product-info-link">
                    <div class="product-desc-content">
                        <p>{!! $product->additional_info !!}</p>
                    </div>
                </div> -->
                <div class="tab-pane fade" id="product-shipping-tab" role="tabpanel"
                    aria-labelledby="product-shipping-link">
                    <div class="product-desc-content">
                        {!! $product->shipping_info !!}
                    </div><!-- End .product-desc-content -->
                </div><!-- .End .tab-pane -->

            </div><!-- End .tab-content -->
        </div><!-- End .product-details-tab -->

    </div><!-- End .container -->
</div><!-- End .page-content -->

<button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

@endsection
@section('javascript')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    document.getElementById('razorpay-button').onclick = function (e) {
        e.preventDefault();

        var options = {
            key: "{{ env('RAZORPAY_KEY') }}", // Replace with your Razorpay key
            // amount: "{{ $product->price  }}", // Amount in paise
            // currency: "USD",
            amount : "100",
            currency: "INR",
            name: "Reach Gems",
            description: "Product Payment",
            image: "https://reachgems.com/public/assets/images/icons/favicon.png",
            handler: function (response) {
                // Handle success - Send response.razorpay_payment_id to server
                alert('Payment successful: ' + response.razorpay_payment_id);
            },
            prefill: {
                name: "{{ auth()->user()->name ?? '' }}",
                email: "{{ auth()->user()->email ?? '' }}"
            },
            theme: {
                color: "#c96"
            }
        };
        var rzp = new Razorpay(options);
        rzp.open();
    };
</script>
@endsection