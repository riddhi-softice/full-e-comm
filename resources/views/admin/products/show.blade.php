@extends('admin.layouts.app')

@section('css')
<style>
    .theam-label {
        color: #4154f1;
    }
</style>
@endsection

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

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Show Products </h5>

                    <div class="mb-3">
                        <label class="form-label fw-bold theam-label">Brand</label>
                        {{-- <div class="border rounded p-2 bg-light"> --}}
                        <div class="rounded p-2 bg-light">
                            {{ $product->brand->name }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold theam-label">SubCategory</label>
                        <div class="rounded p-2 bg-light">
                            {{ $product->subCategory->name }}
                        </div>
                    </div>
                  
                    <div class="mb-3">
                        <label class="form-label fw-bold theam-label">Sale Price</label>
                        <div class="rounded p-2 bg-light">
                            $ {{ number_format(old('price', $product->price), 2) }}
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold theam-label">Description</label>
                        <div class="rounded p-2 bg-light">
                            {{ $product->description }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold theam-label">Shipping Info</label>
                        <div class="rounded p-2 bg-light">
                            {!! old('shipping_info', $product->shipping_info) !!}
                        </div>
                    </div>

                    @if ($product->attributeValues->count())
                        @php
                            $grouped = $product->attributeValues->groupBy('attribute_id');
                        @endphp
                        <label class="form-label fw-bold theam-label">Attributes</label>
                        @foreach ($grouped as $attributeId => $items)
                            <div class="mb-3 rounded p-2 bg-light">
                                <strong>{{ $items->first()->attribute->name }}:</strong>
                                <ul class="mb-0">
                                    @foreach ($items as $item)
                                        <li>
                                            Value: <strong>{{ $item->value }}</strong>
                                            @if ($item->price)
                                                — Price: ₹{{ number_format($item->price, 2) }}
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    @else
                        <p>No attributes available.</p>
                    @endif

                    <div class="mb-3">
                        <label class="form-label fw-bold theam-label">Images</label>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($product->images as $image)
                            <div style="position: relative;">
                                <img src="{{ asset('public/assets/images/demos/demo-2/products/' . $image->path) }}"
                                    style="max-width: 100px; height: auto;" class="img-thumbnail">
                                @if($image->is_primary)
                                <div style="position: absolute; top: 0; left: 0; background: green; color: white; font-size: 12px; padding: 2px 4px;">
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

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Show Products </h5>

                    <div class="mb-3">
                        <label class="form-label fw-bold theam-label">Category</label>
                        <div class="rounded p-2 bg-light">
                            {{ $product->category->name }}
                        </div>
                    </div>
                  
                    <div class="mb-3">
                        <label class="form-label fw-bold theam-label">Product Name</label>
                        <div class="rounded p-2 bg-light">
                            {{ $product->name }}
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold theam-label">Regular Price</label>
                        <div class="rounded p-2 bg-light">
                            $ {{ number_format(old('reseller_price', $product->reseller_price), 2) }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold theam-label">Long Description</label>
                        <div class="rounded p-2 bg-light">
                            {!! old('long_desc', $product->long_desc) !!}
                        </div>
                    </div>
                  
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
@yield('javascript')