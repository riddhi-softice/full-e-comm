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
                    <h5 class="card-title">Add Product Form</h5>

                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
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
                            <label>Product Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Description</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Price</label>
                            <input type="number" step="0.01" name="price" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Sale Price</label>
                            <input type="number" step="0.01" name="reseller_price" class="form-control" required>
                        </div>

                        <!-- <div class="mb-3">
                            <label>Stock</label>
                            <input type="number" name="stock" class="form-control" value="0">
                        </div>
                        <div class="mb-3">
                            <label>Warranty (Years)</label>
                            <input type="number" name="warranty_years" class="form-control">
                        </div> -->

                        <div class="mb-3">
                            <label>Long Description</label>
                            <textarea class="tinymce-editor" name="long_desc"></textarea>
                            <!-- <textarea name="long_desc" class="form-control"></textarea> -->
                        </div>
                        
                        <!-- <div class="mb-3">
                            <label>Additional Info</label>
                            <textarea name="additional_info" class="form-control"></textarea>
                        </div> -->

                        <div class="mb-3">
                            <label>Shipping Info</label>
                            <textarea class="tinymce-editor" name="shipping_info"></textarea>
                            <!-- <textarea name="shipping_info" class="form-control"></textarea> -->
                        </div>

                        <div class="mb-3">
                            <label>Product Images</label>
                            <input type="file" name="images[]" class="form-control" multiple required>
                        </div>

                        <button type="submit" class="btn btn-primary">Create Product</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@yield('javascript')
