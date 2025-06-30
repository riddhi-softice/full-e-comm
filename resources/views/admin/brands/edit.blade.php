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
                        <h5 class="card-title">Edit Brand</h5>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data" id="editForm">
                            @csrf
                            @method('PUT')
                            
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Brand Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="name" value="{{ old('name', $brand->name) }}" required>
                                </div>
                            </div>
                      
                            <div class="row mb-3">
                                <label for="inputImage" class="col-sm-2 col-form-label">Logo</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="file" id="logo" name="logo" onchange="previewLogo(event)">
                                    <img id="img_preview" src="{{ asset('public/assets/images/brands/' . $brand->logo) }}" alt="Current Thumbnail" class="mt-2" style="max-width: 100px;">
                                </div>
                            </div>

                            <div class="row mb-3">
                                {{-- <label class="col-sm-2 col-form-label"></label> --}}
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary" id="submitBtn">Update</button>
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

<script>
//  <!-- submit click disable button -->
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('editForm');
    const button = document.getElementById('submitBtn');

    if (form && button) {
        form.addEventListener('submit', function () {
            button.disabled = true;
            button.innerText = 'Please wait...';
        });
    }
});

// images preview
function previewLogo(event) {
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
