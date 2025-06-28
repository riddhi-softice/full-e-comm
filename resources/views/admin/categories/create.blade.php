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
                        <h5 class="card-title">Add Category Form</h5>

                        <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Category Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Category Word</label>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-success" onclick="addTextField()">Add New Word</button>
                                </div>
                            </div>

                            <div id="additionalFields">
                                <div class="row mb-3">
                                    <label for="inputText" class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="cat_words[]" required>
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="button" class="btn btn-danger" onclick="removeTextField(this)">Remove</button>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit Form</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@yield('javascript')
<script>
    var additionalFieldsCounter = 0;

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

        // Remove the "Remove" button for the first added field
        // if (additionalFieldsCounter === 0) {
        //     newField.querySelector('.btn-danger').style.display = 'none';
        // }

        additionalFields.appendChild(newField);
        additionalFieldsCounter++;
    }

    function removeTextField(button) {
        var parentDiv = button.parentNode.parentNode;
        parentDiv.parentNode.removeChild(parentDiv);
        additionalFieldsCounter--;

        // Show the "Remove" button for the remaining fields
        if (additionalFieldsCounter > 0) {
            var fields = document.getElementById('additionalFields').querySelectorAll('.btn-danger');
            fields[fields.length - 1].style.display = 'block';
        }
    }
</script>
