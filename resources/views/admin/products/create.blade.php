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
                    <h5 class="card-title">Add Product</h5>

                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                        @csrf

                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label fw-bold">Product Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Description</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Price</label>
                                    <input type="number" step="0.01" name="price" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Sale Price</label>
                                    <input type="number" step="0.01" name="reseller_price" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Product Images</label>
                            <input type="file" name="images[]"  id="imageInput" class="form-control" multiple required>
                        </div>
                        <div class="mb-3 d-flex flex-wrap gap-2" id="imagePreviewContainer"></div>
                        
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Long Description</label>
                                    <textarea class="tinymce-editor" name="long_desc"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Shipping Info</label>
                                    <textarea class="tinymce-editor" name="shipping_info"></textarea>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary" id="submitBtn">Create Product</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('javascript')
<!-- Template custom JS File -->
<script src="{{ asset('public/admin/assets/js/custom.js') }}"></script>
@endsection