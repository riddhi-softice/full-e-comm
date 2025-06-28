@extends('admin.layouts.app')
@section('content')
    <div class="pagetitle">
        <h1>Brands</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('brands.index') }}">Brands</a></li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add Brand</h5>

                        <form action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data">
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

                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Brand Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputNumber" class="col-sm-2 col-form-label">Logo</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="file" id="logo" name="logo" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Create</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@yield('javascript')
