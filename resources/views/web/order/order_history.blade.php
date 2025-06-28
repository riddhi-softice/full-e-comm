@extends('web.layouts2.app')
@section('content')

<div class="page-header text-center" style="background-image: url('{{ asset('public/assets/images/page-header-bg.jpg') }}');">
    <div class="container">
        <h1 class="page-title">Orders<span>Shop</span></h1>
    </div><!-- End .container -->
</div><!-- End .page-header -->
<nav aria-label="breadcrumb" class="breadcrumb-nav">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('more-products') }}">Shop</a></li>
            <li class="breadcrumb-item active" aria-current="page">Orders</li>
        </ol>
    </div><!-- End .container -->
</nav><!-- End .breadcrumb-nav -->

<div class="page-content">
    <div class="container">
        <table class="table table-wishlist table-mobile">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Courier Name</th>
                    <th>Tracking</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data['order_history'] as $item)
                <tr>
                    <td class="product-col">
                        <div class="product">
                            <figure class="product-media">
                                <a href="{{ route('product.show', $item->product->id) }}">
                                    <img src="{{ $item->product->firstImage->path ? asset('public/assets/images/demos/demo-2/products/' . $item->product->firstImage->path) : asset('public/assets/images/no-image.jpg') }}" alt="Product image">
                                </a>
                            </figure>
                            <h3 class="product-title">
                                <a href="{{ route('product.show', $item->product->id) }}">{{ $item->product->name }}</a>
                            </h3>
                        </div>
                    </td>
                    <td class="price-col">{{ number_format($item->product->price, 2) }}</td>
                    <td class="stock-col"><span class="in-stock">{{ $item->status }}</span></td>
                    <td class="stock-col"><span class="in-stock">{{ $item['tracking']['shipment_track'][0]['courier_name'] }}</span></td>
                    <td class="stock-col"><span class="in-stock">{{ $item['tracking']['track_url'] }}</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center">
                        <i class="icon-shopping-cart"></i> You haven't placed any orders yet.
                        <a href="{{ route('home') }}">Start Shopping</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table><!-- End .table table-wishlist -->

        <div class="wishlist-share">
            <div class="social-icons social-icons-sm mb-2">
                <label class="social-label">Share on:</label>
                <a href="#" class="social-icon" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                <a href="#" class="social-icon" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                <a href="#" class="social-icon" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
                <a href="#" class="social-icon" title="Youtube" target="_blank"><i class="icon-youtube"></i></a>
            </div><!-- End .soial-icons -->
        </div><!-- End .wishlist-share -->
    </div><!-- End .container -->
</div><!-- End .page-content -->

@endsection
@section('javascript')
@endsection