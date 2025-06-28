@php
$firstImage = $product->images->get(0);
$secondImage = $product->images->get(1);
@endphp

<!-- @php
$whatsappNumber = '917016126901';
$productName = $product->name;
$imageUrl = $firstImage
? asset('public/assets/images/demos/demo-2/products/' . $firstImage->path)
: asset('no-image.jpg');
$message = "Hello, I am interested in this product:\n\n$productName\n\nImage: $imageUrl";
@endphp -->

<!-- <head>
    <meta property="og:title" content="{{ $product->name }}">
    <meta property="og:description" content="Buy {{ $product->name }} online. Best price and features.">
    <meta property="og:image" content="{{ $firstImage ? asset('public/assets/images/demos/demo-2/products/' . $firstImage->path) : asset('no-image.jpg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
</head> -->

@php
    $whatsappNumber = '917016126901';
    $productUrl = route('product.show', $product->id);
    $message = "Hello, I'm interested in this product:\n\n$productUrl";
    $encodedMessage = urlencode($message);
@endphp

<div class="col-6 col-md-4 col-lg-3 mb-4">
    <div class="product product-11 mt-v3 text-center">
        <figure class="product-media">
            <a href="{{ route('product.show', $product->id) }}">
                <img src="{{ $firstImage ? asset('public/assets/images/demos/demo-2/products/' . $firstImage->path) : asset('public/assets/images/no-image.jpg') }}"
                    alt="{{ $product->name }}" class="product-image">
                <img src="{{ $secondImage ? asset('public/assets/images/demos/demo-2/products/' . $secondImage->path) : asset('public/assets/images/no-image.jpg') }}"
                    alt="{{ $product->name }}" class="product-image-hover">
            </a>
        </figure>

        <div class="product-body">
            <h3 class="product-title">
                <a href="{{ route('product.show', $product->id) }}">{{ $product->name }}</a>
            </h3>
            <!--<div class="product-price">${{ $product->price }}</div>-->
            <div class="product-price">
                @if(strtolower($data['country']) === 'india')
                    ₹{{ $product->display_price }}
                @else
                    ${{ number_format($product->display_price, 2) }}
                @endif
            </div>
        </div>

        <div class="product-action">
            <!-- <a href="https://wa.me/{{ $whatsappNumber }}?text={{ $encodedMessage }}" class="btn-product btn-cart" target="_blank">
                <span>Order Now</span>
            </a> -->
             <a href="{{ route('order.add', $product->id) }}" class="btn-product btn-cart"><span>Order Now</span></a>
        </div>
    </div>
</div>

        
        <!-- <div class="product-action">
            <a href="https://wa.me/{{ $whatsappNumber }}?text={{ urlencode($message) }}" class="btn-product btn-cart"
                target="_blank">
                <span>Order Now</span>
            </a>
            <a href="{{ route('order.add', $product->id) }}" class="btn-product btn-cart"><span>Order Now</span></a>
        </div> -->