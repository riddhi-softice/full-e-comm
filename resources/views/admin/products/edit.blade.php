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
                
                    <ul class="nav nav-tabs mb-3" id="customTabs">
                        <li class="nav-item">
                            <a class="nav-link custom-tab active" data-target="#basic">Basic Info</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link custom-tab" data-target="#cate">Category Info</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link custom-tab" data-target="#details">Product Images</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link custom-tab" data-target="#attributes">Product Attributes</a>
                        </li>
                    </ul>

                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="productForm">
                        @csrf
                        @method('PUT')

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->unique() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <div class="tab-content">
                            {{-- Basic Info --}}
                            <div class="tab-pane custom-tab-pane active" id="basic" >
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Product Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}">
                                </div>
                    
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Short Description</label>
                                    <textarea name="description" class="form-control" rows="3">{{ $product->description }}</textarea>
                                </div>
                    
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label fw-bold">Sale Price ($)</label>
                                        <input type="number" step="0.01" value="{{ old('price', $product->price) }}" name="price" class="form-control">
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label fw-bold">Regular Price ($)</label>
                                        <input type="number" step="0.01" name="reseller_price" class="form-control"  value="{{ old('reseller_price', $product->reseller_price) }}" >
                                    </div>
                                </div>
                    
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label fw-bold">Long Description</label>
                                        <textarea class="tinymce-editor form-control" name="long_desc"> {!! $product->long_desc !!} </textarea>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label fw-bold">Shipping Information</label>
                                        <textarea class="tinymce-editor form-control" name="shipping_info"> {!! $product->shipping_info !!} </textarea>
                                    </div>
                                </div>

                                <div class="text-end mt-3">
                                    <button type="button" class="btn btn-secondary next-tab-btn">Next</button>
                                </div>                       
                            </div>
                    
                            {{-- Category Info --}}
                            <div class="tab-pane custom-tab-pane" id="cate" style="display: none;">
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label fw-bold">Select Category</label>
                                        <select class="form-control" id="cat_id" name="cat_id">
                                            <option value="" disabled selected>-- Select Category --</option>
                                            @foreach ($category as $value)
                                                <option value="{{ $value->id }}" {{ $value->id == $product->cat_id ? 'selected' : ''}}>{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label fw-bold">Select Subcategory</label>
                                        <select class="form-control" id="sub_cat_id" name="sub_cat_id">
                                            <option value="" disabled selected>-- Select Subcategory --</option>
                                            @foreach ($subcategories as $value1)
                                                <option value="{{ $value1->id }}" {{ $value1->id == $product->sub_cat_id ? 'selected' : ''}}>{{ $value1->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label fw-bold">Select Brand</label>
                                        <select class="form-control" id="brand_id" name="brand_id">
                                            <option value="" disabled selected>-- Select Brand --</option>
                                            @foreach ($brand as $val)
                                                <option value="{{ $val->id }}" {{ $val->id == $product->brand_id ? 'selected' : '' }} >{{ $val->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="text-end mt-3">
                                    <button type="button" class="btn btn-secondary next-tab-btn">Next</button>
                                </div>
                            </div>
                    
                            {{-- Images --}}
                            <div class="tab-pane custom-tab-pane" id="details" style="display: none;">
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Upload Product Images</label>
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
                                
                                <div class="text-end mt-3">
                                    <button type="button" class="btn btn-secondary next-tab-btn">Next</button>
                                </div>
                            </div>
                                              
                            {{-- Attributes --}}
                            <div class="tab-pane custom-tab-pane " id="attributes" style="display: none;">
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label fw-bold">Attributes</label>
                                    <div class="col-sm-2">
                                        <button type="button" class="btn btn-success" onclick="addAttributeField()">Add Attribute</button>
                                    </div>
                                </div>

                                <div id="additionalFields">
                                    @forelse ($attributeValues as $attrId => $items)
                                        <div class="row mb-3 attribute-row">
                                            <div class="col-sm-4">
                                                <select class="form-control attribute-select" onchange="handleAttributeChange(this)">
                                                    <option disabled>-- Select Attribute --</option>
                                                    @foreach ($attribute as $value)
                                                        <option value="{{ $value->id }}" data-name="{{ strtolower($value->name) }}"
                                                            {{ $attrId == $value->id ? 'selected' : '' }}>
                                                            {{ $value->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-6 value-container">
                                                @foreach ($items as $index => $entry)
                                                    <div class="input-group mb-1">
                                                        <input type="text" class="form-control" name="attributes[{{ $attrId }}][{{ $index }}][value]"
                                                               value="{{ $entry['value'] }}" placeholder="Value" required>
                                                        <input type="number" class="form-control" name="attributes[{{ $attrId }}][{{ $index }}][price]"
                                                               value="{{ $entry['price'] }}" placeholder="Price" required>
                                                        @if ($loop->first)
                                                            <button class="btn btn-secondary" type="button"
                                                                    onclick="addMoreValues(this, {{ $attrId }})">+</button>
                                                        @else
                                                            <button class="btn btn-danger" type="button" onclick="removeValueField(this)">×</button>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="col-sm-2">
                                                <button type="button" class="btn btn-danger" onclick="removeTextField(this)">Remove</button>
                                            </div>
                                        </div>
                                    @empty
                                    @endforelse
                                </div>
                                                    
                                {{-- <div id="additionalFields">
                                    <div class="row mb-3 attribute-row">
                                        <div class="col-sm-4">
                                            <select class="form-control attribute-select" onchange="handleAttributeChange(this)">
                                                <option value="" disabled selected>-- Select Attribute --</option>
                                                @foreach ($attribute as $value)
                                                    <option value="{{ $value->id }}" data-name="{{ strtolower($value->name) }}">{{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-6 value-container">
                                            <div class="input-group mb-1">
                                                <input type="text" class="form-control" name="attributes[][0][value]" placeholder="Value">
                                                <input type="number" class="form-control" name="attributes[][0][price]" placeholder="Price">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" class="btn btn-danger" onclick="removeTextField(this)">Remove</button>
                                        </div>
                                    </div>
                                </div> --}}
                                                                      
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary" id="submitBtn">Create Product</button>
                                </div>
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
{{-- NEXT BUTTON WITH TAB ACTIVE MANAGE --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tabs = document.querySelectorAll(".custom-tab");
        const tabPanes = document.querySelectorAll(".custom-tab-pane");
        const nextButtons = document.querySelectorAll(".next-tab-btn");
    
        nextButtons.forEach(function (btn) {
            btn.addEventListener("click", function () {
                let currentPane = btn.closest(".custom-tab-pane");
                let currentIndex = Array.from(tabPanes).indexOf(currentPane);
                let nextIndex = currentIndex + 1;
    
                if (nextIndex < tabPanes.length) {
                    // Hide all panes
                    tabPanes.forEach(p => p.style.display = "none");
    
                    // Show next
                    tabPanes[nextIndex].style.display = "block";
    
                    // Update tab active class
                    tabs.forEach(t => t.classList.remove("active"));
                    tabs[nextIndex].classList.add("active");
                }
            });
        });
    
        // Handle tab clicks (if needed)
        tabs.forEach(function (tab, index) {
            tab.addEventListener("click", function () {
                tabPanes.forEach(p => p.style.display = "none");
                tabPanes[index].style.display = "block";
    
                tabs.forEach(t => t.classList.remove("active"));
                tab.classList.add("active");
            });
        });
    });
</script>  

{{-- SUB CATEGORY DATA GET --}}
<script>
    document.getElementById('cat_id').addEventListener('change', function () {
        let catId = this.value;

        let url = "{{ route('product.sub-cate', ':id') }}".replace(':id', catId);   
        fetch(url)
        .then(response => response.json())
        .then(data => {
            let subCatSelect = document.getElementById('sub_cat_id');
            subCatSelect.innerHTML = '<option value="" disabled selected>-- Select Subcategory --</option>';

            data.forEach(function (subcat) {
                let option = document.createElement('option');
                option.value = subcat.id;
                option.text = subcat.name;
                subCatSelect.appendChild(option);
            });
        });
    });
</script>

{{-- ATTRIBUTE FIELD SET --}}
<script>
    function addAttributeField() {
        const html = `
        <div class="row mb-3 attribute-row">
            <div class="col-sm-4">
                <select class="form-control attribute-select" name="attribute_ids[]" onchange="handleAttributeChange(this)">
                    <option value="" disabled selected>-- Select Attribute --</option>
                    @foreach ($attribute as $value)
                        <option value="{{ $value->id }}" data-name="{{ strtolower($value->name) }}">{{ $value->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-6 value-container">
                 <div class="input-group mb-1">
                    <input type="text" class="form-control" name="attributes[][0][value]" placeholder="Value">
                    <input type="number" class="form-control" name="attributes[][0][price]" placeholder="Price">
                </div>
            </div>
            <div class="col-sm-2">
                <button type="button" class="btn btn-danger" onclick="removeTextField(this)">Remove</button>
            </div>
        </div>`;
        document.getElementById('additionalFields').insertAdjacentHTML('beforeend', html);
    }

    function handleAttributeChange(selectElement) {
        const selectedId = selectElement.value;
        const attrName = selectElement.options[selectElement.selectedIndex].dataset.name;
        const valueContainer = selectElement.closest('.attribute-row').querySelector('.value-container');
    
        if (!selectedId) return;

        // Add dynamic input fields using the selected ID
        valueContainer.innerHTML = `
            <div class="input-group mb-1">
                <input type="text" class="form-control" name="attributes[${selectedId}][0][value]" placeholder="Value">
                <input type="number" class="form-control" name="attributes[${selectedId}][0][price]" placeholder="Price">
                <button class="btn btn-secondary" type="button" onclick="addMoreValues(this, ${selectedId})">+</button>
            </div>
        `;
    }

    function addMoreValues(button, attrId) {
        const container = button.closest('.value-container');
        const index = container.querySelectorAll('.input-group').length;

        const newInput = document.createElement('div');
        newInput.className = 'input-group mb-1';
        newInput.innerHTML = `
            <input type="text" class="form-control" name="attributes[${attrId}][${index}][value]" placeholder="Value">
            <input type="number" class="form-control" name="attributes[${attrId}][${index}][price]" placeholder="Price">
            <button class="btn btn-danger" type="button" onclick="removeValueField(this)">×</button>
        `;
        container.appendChild(newInput);
    }

    function removeValueField(button) {
        button.closest('.input-group').remove();
    }
    function removeTextField(button) {
        button.closest('.attribute-row').remove();
    }
</script>

{{-- SUBMIT PROCEES AND IMAGE PREVIEW --}}
<script>
    //  <!-- submit click disable button -->
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('productForm');
        const button = document.getElementById('submitBtn');

        if (form && button) {
            form.addEventListener('submit', function () {
                button.disabled = true;
                button.innerText = 'Please wait...';
            });
        }
    });
    // images preview
    document.addEventListener('DOMContentLoaded', function () {
        const imageInput = document.getElementById('imageInput');
        const previewContainer = document.getElementById('imagePreviewContainer');

        imageInput.addEventListener('change', function () {
            previewContainer.innerHTML = ''; // Clear old previews

            Array.from(this.files).forEach(file => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'img-thumbnail';
                        img.style.maxWidth = '100px';
                        img.style.marginRight = '10px';
                        img.style.marginBottom = '10px';
                        previewContainer.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    });
</script>

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