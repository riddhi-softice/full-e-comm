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

                        <div class="row">

                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Version Setting</h5>

                                        <div class="row mb-12">
                                            <label for="inputText" class="col-sm-4 col-form-label">Product Name </label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                                            </div>
                                        </div>

                                        <div class="row mb-12">
                                            <label for="inputText" class="col-sm-4 col-form-label">Description </label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" name="description" value="{{ old('description') }}" required>
                                            </div>
                                        </div>
                                      
                                        <div class="row mb-12">
                                            <label for="inputText" class="col-sm-4 col-form-label">Price </label>
                                            <div class="col-sm-12">
                                                <input type="number" class="form-control"  step="0.01" name="price" value="{{ old('description') }}" required>
                                            </div>
                                        </div>

                                        <div class="row mb-12">
                                            <label for="inputText" class="col-sm-4 col-form-label">Sale Price </label>
                                            <div class="col-sm-12">
                                                <input type="number" class="form-control"  step="0.01" name="reseller_price" value="{{ old('description') }}" required>
                                            </div>
                                        </div>
                                      
                                        <div class="row mb-12">
                                            <label for="inputText" class="col-sm-4 col-form-label">Product Images </label>
                                            <div class="col-sm-12">
                                                <input type="file" name="images[]" class="form-control" multiple required>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Other Setting</h5>
                                       
                                        <div class="row mb-12">
                                            <label for="inputText" class="col-sm-4 col-form-label">Long Desc</label>
                                            <div class="col-sm-12">
                                                <textarea class="tinymce-editor" name="long_desc"></textarea>
                                            </div>
                                        </div>
                                        <div class="row mb-12">
                                            <label for="inputText" class="col-sm-4 col-form-label">Shipping Info</label>
                                            <div class="col-sm-12">
                                                <textarea class="tinymce-editor" name="shipping_info"></textarea>
                                            </div>
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
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
