@extends('layouts.app')

@section('content')
    <div class="pagetitle">
        <h1>Category</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('categories.index') }}">Categories</a></li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Category Form</h5>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Category Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="name" value="{{ old('name', $category->name) }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Category Word</label>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-success" onclick="addTextField()">Add New Word</button>
                                </div>
                            </div>

                            <div id="additionalFields">
                                @foreach(explode(',', $category->cat_words) as $fieldValue)
                                    <div class="row mb-3">
                                        <label for="inputText" class="col-sm-2 col-form-label"></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="cat_words[]" value="{{ $fieldValue }}" required>
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" class="btn btn-danger" onclick="removeTextField(this)">Remove</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="row mb-3">
                                {{-- <label class="col-sm-2 col-form-label"></label> --}}
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Update Form</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@yield('javascript')
<script>
    function addTextField() {
        var additionalFields = document.getElementById('additionalFields');
        var newField = document.createElement('div');
        newField.className = 'row mb-3';
        newField.innerHTML = `
            <label for="inputText" class="col-sm-2 col-form-label"></label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="cat_words[]" required>
            </div>
            <div class="col-sm-2">
                <button type="button" class="btn btn-danger" onclick="removeTextField(this)">Remove</button>
            </div>
        `;
        additionalFields.appendChild(newField);
    }

    function removeTextField(button) {
        var parentDiv = button.parentNode.parentNode;
        parentDiv.parentNode.removeChild(parentDiv);
    }
</script>
