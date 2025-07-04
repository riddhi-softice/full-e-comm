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

                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                        @csrf

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
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                                </div>
                    
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Short Description</label>
                                    <textarea name="description" class="form-control" rows="3"></textarea>
                                </div>
                    
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label fw-bold">Sale Price ($)</label>
                                        <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}">
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label fw-bold">Regular Price ($)</label>
                                        <input type="number" step="0.01" name="reseller_price" class="form-control" value="{{ old('reseller_price') }}" >
                                    </div>
                                </div>
                    
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label fw-bold">Long Description</label>
                                        <textarea class="tinymce-editor form-control" name="long_desc"></textarea>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label fw-bold">Shipping Information</label>
                                        <textarea class="tinymce-editor form-control" name="shipping_info"></textarea>
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
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label fw-bold">Select Subcategory</label>
                                        <select class="form-control" id="sub_cat_id" name="sub_cat_id">
                                            <option value="" disabled selected>-- Select Subcategory --</option>
                                            {{-- Dynamically populate based on selected category --}}
                                        </select>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label fw-bold">Select Brand</label>
                                        <select class="form-control" id="brand_id" name="brand_id">
                                            <option value="" disabled selected>-- Select Brand --</option>
                                            @foreach ($brand as $val)
                                                <option value="{{ $val->id }}">{{ $val->name }}</option>
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
                                <div class="mb-3 d-flex flex-wrap gap-2" id="imagePreviewContainer"></div>
                                
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
                                            <input type="text" class="form-control" name="attributes[][0][value]" placeholder="Value" required>
                                            {{-- <div class="input-group mb-1">
                                                <input type="text" class="form-control" name="attributes[][0][value]" placeholder="Value">
                                                <input type="number" class="form-control" name="attributes[][0][price]" placeholder="Price">
                                            </div> --}}
                                            {{-- input will be inserted dynamically here --}}
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" class="btn btn-danger" onclick="removeTextField(this)">Remove</button>
                                        </div>
                                    </div>
                                </div>
                                                                      
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
@endsection
@section('javascript')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{-- ONLY TAB ACTIVE MANAGE --}}
{{-- <script>
    $(document).ready(function() {
        $('.custom-tab').on('click', function(e) {
            e.preventDefault();
            // Remove active class from all tabs and hide all tab panes
            $('.custom-tab').removeClass('active');
            $('.custom-tab-pane').hide();
    
            // Activate clicked tab and show its target pane
            $(this).addClass('active');
            var target = $(this).data('target');
            $(target).show();
        });
    });
</script> --}}

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
                <input type="text" class="form-control" name="attributes[][0][value]" placeholder="Value" required>
                
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

        if (attrName === 'size' ) {
            // Add dynamic input fields using the selected ID
            valueContainer.innerHTML = `
                <div class="input-group mb-1">
                    <input type="text" class="form-control" name="attributes[${selectedId}][0][value]" placeholder="Value">
                    <input type="number" class="form-control" name="attributes[${selectedId}][0][price]" placeholder="Price">
                    <button class="btn btn-secondary" type="button" onclick="addMoreValues(this, ${selectedId}, '${attrName}')">+</button>
                </div>
            `;
        } else if (attrName === 'color'){
            valueContainer.innerHTML = `
                <div class="input-group mb-2">
                    <input type="text" class="form-control" name="attributes[${selectedId}][0][value]" placeholder="Value" required>
                    <input type="file" class="form-control" name="attributes[${selectedId}][0][image]"  required>
                    <button class="btn btn-secondary" type="button" onclick="addMoreValues(this, ${selectedId}, '${attrName}')">+</button>
                </div>
            `;
        } else {
            valueContainer.innerHTML = `
                <input type="text" class="form-control" name="attributes[${selectedId}][0][value]" placeholder="Value" required>
            `;
        }
    }

    function addMoreValues(button, attrId, attrName) {
        const container = button.closest('.value-container');
        const index = container.querySelectorAll('.input-group').length;

        const newInput = document.createElement('div');
        newInput.className = 'input-group mb-1';

        let innerHTML = '';

        if (attrName === 'size') {
            innerHTML = `
                <input type="text" class="form-control" name="attributes[${attrId}][${index}][value]" placeholder="Value" required>
                <input type="number" class="form-control" name="attributes[${attrId}][${index}][price]" placeholder="Price" required>
                <button class="btn btn-danger" type="button" onclick="removeValueField(this)">×</button>
            `;
        } else if (attrName === 'color') {
            innerHTML = `
                <input type="text" class="form-control" name="attributes[${attrId}][${index}][value]" placeholder="Color Name" required>
                <input type="file" class="form-control" name="attributes[${attrId}][${index}][image]" required>
                <button class="btn btn-danger" type="button" onclick="removeValueField(this)">×</button>
            `;
        } else {
            innerHTML = `
                <input type="text" class="form-control" name="attributes[${attrId}][${index}][value]" placeholder="Value" required>
                <button class="btn btn-danger" type="button" onclick="removeValueField(this)">×</button>
            `;
        }

        newInput.innerHTML = innerHTML;
        container.appendChild(newInput);
    }
    
    // function addMoreValues(button, attrId) {
    //     const container = button.closest('.value-container');
    //     const index = container.querySelectorAll('.input-group').length;

    //     const newInput = document.createElement('div');
    //     newInput.className = 'input-group mb-1';
    //     newInput.innerHTML = `
    //         <input type="text" class="form-control" name="attributes[${attrId}][${index}][value]" placeholder="Value">
    //         <input type="number" class="form-control" name="attributes[${attrId}][${index}][price]" placeholder="Price">
    //         <button class="btn btn-danger" type="button" onclick="removeValueField(this)">×</button>
    //     `;
    //     container.appendChild(newInput);
    // }

   
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

{{-- <script>
    function addAttributeField() {
        const html = `
        <div class="row mb-3 attribute-row">
            <div class="col-sm-4">
                <select class="form-control attribute-select" name="attribute_ids[]" onchange="handleAttributeChange(this)" required>
                    <option value="" disabled selected>-- Select Attribute --</option>
                    @foreach ($attribute as $value)
                        <option value="{{ $value->id }}" data-name="{{ strtolower($value->name) }}">{{ $value->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-6 value-container">
                <input type="text" class="form-control" name="attributes[][value]" placeholder="Attribute Value" required>
            </div>
            <div class="col-sm-2">
                <button type="button" class="btn btn-danger" onclick="removeTextField(this)">Remove</button>
            </div>
        </div>`;
        document.getElementById('additionalFields').insertAdjacentHTML('beforeend', html);
    }
    
    function removeTextField(btn) {
        btn.closest('.attribute-row').remove();
    }
    
    function handleAttributeChange(selectElement) {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const attrName = selectedOption.getAttribute('data-name');
        const container = selectElement.closest('.attribute-row').querySelector('.value-container');
    
        // Only for color or size attributes allow multiple values
        // if (attrName === 'color' || attrName === 'size') {
            container.innerHTML = `
                <div class="value-group">
                    <div class="input-group mb-1">
                        <input type="text" class="form-control" name="attributes[][value][]" placeholder="Value 1" required>
                        <button class="btn btn-secondary" type="button" onclick="addMoreValues(this)">+</button>
                    </div>
                </div>
            `;
        // } else {
        //     container.innerHTML = `
        //         <input type="text" class="form-control" name="attributes[][value]" placeholder="Attribute Value" required>
        //     `;
        // }
    }
    function addMoreValues(button) {
        const valueGroup = button.closest('.value-group');

        const inputGroup = document.createElement('div');
        inputGroup.className = 'input-group mb-1';
        inputGroup.innerHTML = `
            <input type="text" class="form-control" name="attributes[][value][]" placeholder="Another Value" required>
            <button class="btn btn-danger" type="button" onclick="removeValueField(this)">×</button>
        `;
        valueGroup.appendChild(inputGroup);
    }
    function removeValueField(button) {
        button.closest('.input-group').remove();
    }
</script>   --}}

@endsection