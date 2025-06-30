@extends('admin.layouts.app')
@section('content')
    <div class="pagetitle">
        <h1>SubCategories</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('sub_categories.index') }}">SubCategories</a></li>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add SubCategory</h5>

                        <form action="{{ route('sub_categories.store') }}" method="POST" enctype="multipart/form-data" id="createForm">
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
                                <label for="cat_id" class="col-sm-2 col-form-label">Select Category</label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="cat_id" name="cat_id" required>
                                        @foreach ($category as $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputNumber" class="col-sm-2 col-form-label">Image</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="file" id="image" name="image" onchange="previewImage(event)" required>
                                    <img id="img_preview" src="" alt="" class="mt-2" style="max-width: 100px;">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" id="submitBtn">Create</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('javascript')
<script>
    //  <!-- submit click disable button -->
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('createForm');
        const button = document.getElementById('submitBtn');
    
        if (form && button) {
            form.addEventListener('submit', function () {
                button.disabled = true;
                button.innerText = 'Please wait...';
            });
        }
    });
    // images preview
    function previewImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('img_preview');
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
