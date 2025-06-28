@extends('admin.layouts.app')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

@section('content')
<div class="pagetitle">
    <h1>Products</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Products</li>
        </ol>
    </nav>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<section class="section">
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="alertMsg" style="display: none">
        Product deleted successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title">Product List</h5>
                        <div>
                            <a href="{{ route('products.create') }}" class="btn btn-primary">Add Product</a>
                        </div>
                    </div>
                    <table class="table datatable text-capitalize ">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th data-type="date" data-format="YYYY/DD/MM">Create Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $key=>$value)
                            <tr>
                                <td>{{ $key + 1}}</td>
                                <td>
                                    @if ($value->firstImage->path)
                                    <a href="{{ asset('public/assets/images/demos/demo-2/products/' . $value->firstImage->path) }}"
                                        target="_blank">
                                        <img src="{{ asset('public/assets/images/demos/demo-2/products/' . $value->firstImage->path) }}"
                                            alt="{{ $value->firstImage->path }}" width="50" height="50">
                                    </a>
                                    @else
                                        No image
                                    @endif
                                </td>
                                <td>{{ $value->name }}</td>
                                <td>${{ $value->price }}</td>
                                <td>{{ $value->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('products.show', $value->id) }}" class="btn btn-sm btn-secondary">View</a>
                                    <a href="{{ route('products.edit', $value->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <button class="btn btn-danger btn-sm deleteData" data-id="{{ $value->id }}"
                                        data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
                <button type="button" class="close custom-close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this record?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary custom-close">Cancel</button>
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> -->
                <!-- <button class="btn btn-danger btn-sm deleteData" data-toggle="modal" data-target="#confirmDeleteModal"> -->
                <button type="button" class="btn btn-danger" data-dismiss="modal" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

@endsection
@yield('javascript')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.2/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        // Custom close icon or cancel button
        $(document).on('click', '.custom-close', function() {
            $('#confirmDeleteModal').modal('hide');
        });
        // You can also add an Esc key fallback if needed:
        $(document).on('keyup', function(e) {
            if (e.key === "Escape") {
                $('#confirmDeleteModal').modal('hide');
            }
        });
    });

    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // When delete button is clicked, get the ID
        $(document).on('click', '.deleteData', function() {
            var id = $(this).data('id');
            $('#confirmDelete').data('id', id);
        });

        $(document).on('click', '#confirmDelete', function() {
            var id = $(this).data('id');
            $.ajax({
                type: "POST",
                // url: '/admin/products/delete' + id,
                url: "{{ route('products.delete', ':id') }}".replace(':id', id),
                success: function(data) {
                    // $('#confirmDeleteModal').modal('hide');
                    // $('.modal-backdrop').remove();
                    // $('#table_Data').DataTable().ajax.reload(null,
                    //     false); // Reload DataTable without resetting pagination
                    $('#alertMsg').show().delay(3000)
                .fadeOut(); // Show the alert message- Show for 3 seconds and fade out
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('Error deleting item:', error);
                }
            });
        });
    });
</script>