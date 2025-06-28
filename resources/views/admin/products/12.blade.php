@extends('admin.layouts.app')

<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

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
                    <h5 class="card-title">Edit Products Form</h5>

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Nav Tabs -->
                    <!-- <ul class="nav nav-tabs mb-3" id="productTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="basic-tab" data-toggle="tab" href="#basic" role="tab">Basic
                                Info</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="details-tab" data-toggle="tab" href="#details" role="tab">Descriptions & Images</a>
                        </li>
                    </ul> -->

                    <ul class="nav nav-tabs mb-3" id="customTabs">
                        <li class="nav-item">
                            <a class="nav-link active custom-tab" data-target="#basic">Basic Info</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link custom-tab" data-target="#details">Descriptions & Images</a>
                        </li>
                    </ul>

                    <!-- Form Start -->
                    <form action="{{ route('products.update', $product->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="tab-content">
                            <div class="tab-pane custom-tab-pane active" id="basic">
                                <div class="mb-3">
                                    <label>Product Name</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ old('name', $product->name) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label>Price</label>
                                    <input type="number" step="0.01" name="price" class="form-control"
                                        value="{{ old('price', $product->price) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label>Sale Price</label>
                                    <input type="number" step="0.01" name="reseller_price" class="form-control"
                                        value="{{ old('reseller_price', $product->reseller_price) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label>Description</label>
                                    <textarea name="description"
                                        class="form-control">{{ old('description', $product->description) }}</textarea>
                                </div>
                            </div>

                            <!-- Descriptions & Images -->
                            <div class="tab-pane custom-tab-pane" id="details" style="display: none;">
                                <div class="mb-3">
                                    <label>Long Description</label>
                                    <textarea class="tinymce-editor"
                                        name="long_desc">{!! $product->long_desc !!}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label>Shipping Info</label>
                                    <textarea class="tinymce-editor"
                                        name="shipping_info">{!! $product->shipping_info !!}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label>Product Images</label>
                                    <input type="file" name="images[]" class="form-control" multiple>

                                    <div class="mt-2 d-flex flex-wrap gap-2">
                                        @foreach($product->images as $image)
                                        <div style="position: relative;">
                                            <img src="{{ asset('public/assets/images/demos/demo-2/products/' . $image->path) }}"
                                                style="max-width: 100px; height: auto;" class="img-thumbnail">
                                            @if($image->is_primary)
                                            <div
                                                style="position: absolute; top: 0; left: 0; background: green; color: white; font-size: 12px; padding: 2px 4px;">
                                                Primary</div>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                        <!-- Submit -->
                        <div class="row mt-3">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('javascript')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.custom-tab').on('click', function(e) {
        e.preventDefault();

        // Remove active class from all tabs and hide all tab panes
        $('.custom-tab').removeClass('active');
        $('.custom-tab-pane').hide();

        // Activate clicked tab and show its target pane
        $(this).addClass('active');
        var target = $(this).data('target');
        $(target).show();
    });
});
</script>
<!-- Init script -->
