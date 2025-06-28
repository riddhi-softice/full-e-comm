@extends('admin.layouts.app')

@section('content')
<div class="pagetitle">
    <h1>Products</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('products.index') }}">Products</a></li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Show Products </h5>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Product Name</label>
                        <div class="border rounded p-2 bg-light">
                            {{ old('name', $product->name) }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <div class="border rounded p-2 bg-light">
                            {{ old('description', $product->description) }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Price</label>
                        <div class="border rounded p-2 bg-light">
                            ₹ {{ number_format(old('price', $product->price), 2) }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Sale Price</label>
                        <div class="border rounded p-2 bg-light">
                            ₹ {{ number_format(old('reseller_price', $product->reseller_price), 2) }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Long Description</label>
                        <div class="border rounded p-2 bg-light">
                            {!! old('long_desc', $product->long_desc) !!}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Shipping Info</label>
                        <div class="border rounded p-2 bg-light">
                            {!! old('shipping_info', $product->shipping_info) !!}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Product Images</label>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($product->images as $image)
                            <div style="position: relative;">
                                <img src="{{ asset('public/assets/images/demos/demo-2/products/' . $image->path) }}"
                                    style="max-width: 100px; height: auto;" class="img-thumbnail">
                                @if($image->is_primary)
                                <div
                                    style="position: absolute; top: 0; left: 0; background: green; color: white; font-size: 12px; padding: 2px 4px;">
                                    Primary
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@yield('javascript')