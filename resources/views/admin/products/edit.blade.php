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
                    <h5 class="card-title">Edit Products</h5>

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('products.update', $product->id) }}" method="POST"
                        enctype="multipart/form-data" id="productForm">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Product Name</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $product->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Description</label>
                            <textarea name="description"
                                class="form-control">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Price</label>
                                    <input type="number" step="0.01" name="price" class="form-control"
                                        value="{{ old('price', $product->price) }}" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Sale Price</label>
                                    <input type="number" step="0.01" name="reseller_price" class="form-control"
                                        value="{{ old('reseller_price', $product->reseller_price) }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="mb-3">
                            <label class="form-label fw-bold">Product Images</label>
                            <input type="file" name="images[]" id="imageInput" class="form-control" multiple>

                            <div class="mt-2 d-flex flex-wrap gap-2" id="imagePreviewContainer">
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
                        </div> -->

                        <div class="mb-3">
                            <label class="form-label fw-bold">Product Images</label>
                            <input type="file" name="images[]" id="imageInput" class="form-control" multiple>
                        </div>
                        <div class="mb-3">
                            <div class="mt-2 d-flex flex-wrap gap-2" id="imagePreviewContainer">
                                @foreach($product->images as $image)
                                <div style="position: relative;" class="image-wrapper image-item"
                                    data-id="{{ $image->id }}">
                                    <img src="{{ asset('public/assets/images/demos/demo-2/products/' . $image->path) }}"
                                        style="max-width: 100px; height: auto;" class="img-thumbnail">

                                    <button type="button" class="btn btn-danger btn-sm delete-image"
                                        style="position: absolute; top: -5px; right: -2px; border-radius: 50%; padding: 2px 6px; font-size: 10px;"
                                        data-id="{{ $image->id }}" onclick="deleteImage({{ $image->id }})">
                                        &times;
                                    </button>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Long Description</label>
                                    <textarea class="tinymce-editor" name="long_desc" rows="3" cols="2">
                                            {!! $product->long_desc !!}
                                        </textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Shipping Info</label>
                                    <textarea class="tinymce-editor" name="shipping_info" rows="3" cols="2">
                                            {!! $product->shipping_info !!}
                                        </textarea>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="mb-3">
                            <label>Additional Info</label>
                                <textarea class="tinymce-editor" name="additional_info" rows="3" cols="2">
                                    {!! $product->additional_info !!}
                                </textarea>
                        </div> -->

                        <div class="row mb-3">
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

<!-- Confirm Delete Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="close custom-close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="confirmDeleteModalMessage">
                Are you sure you want to delete this record?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary custom-close">Cancel</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('javascript')
<!-- Template Main JS File -->
<script src="{{ asset('public/admin/assets/js/custom.js') }}"></script>
<script>
let imageIdToDelete = null;

function deleteImage(imageId) {
    const imageItems = document.querySelectorAll('#imagePreviewContainer .image-item');
    // console.log(imageItems.length);

    // Only 1 image left
    if (imageItems.length <= 1) {
        // Set modal message
        document.getElementById('confirmDeleteModalMessage').innerText = 'At least one image must remain.';
        // Disable delete button
        document.getElementById('confirmDelete').style.display = 'none';
    } else {
        // Normal confirmation
        document.getElementById('confirmDeleteModalMessage').innerText =
            'Are you sure you want to delete this image?';
        document.getElementById('confirmDelete').style.display = 'inline-block';
        imageIdToDelete = imageId;
    }
    // Show the modal
    const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
    modal.show();
}

// Handle confirm delete button
document.getElementById('confirmDelete').addEventListener('click', function() {
    if (!imageIdToDelete) return;

    const url = "{{ route('products.image.delete', ':id') }}".replace(':id', imageIdToDelete);

    fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Remove image from DOM
            document.querySelector(`[data-id="${imageIdToDelete}"]`).remove();
            imageIdToDelete = null;
        });

    // Hide modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('confirmDeleteModal'));
    modal.hide();
});

// Close modal handlers
document.querySelectorAll('.custom-close').forEach(btn => {
    btn.addEventListener('click', () => {
        imageIdToDelete = null;

        const modalEl = document.getElementById('confirmDeleteModal');
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        modalInstance.hide();
    });
});
</script>

@endsection