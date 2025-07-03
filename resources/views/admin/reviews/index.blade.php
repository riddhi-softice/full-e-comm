@extends('admin.layouts.app')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

@section('content')
    <div class="pagetitle">
        <h1>Reviews</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Reviews</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="alertMsg" style="display: none">
            Review deleted successfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title">Review List</h5>
                            {{-- <div>
                                <a href="{{ route('reviews.create') }}" class="btn btn-primary">Add Review</a>
                            </div> --}}
                        </div>
                        <table class="table data-table" id="table_Data">
                            <thead>
                                <tr>
                                    <th>UserName</th>
                                    <th>ProductName</th>
                                    <th>Rating</th>
                                    <th>Review Title</th>
                                    <th>Comment</th>
                                    <th data-type="date" data-format="YYYY/DD/MM">Register Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this record?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@yield('javascript')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#table_Data').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('reviews.index') }}",
            columns: [
                {data: 'user_name', name: 'user_name'},
                {data: 'product_name', name: 'product_name'},
                {data: 'rating', name: 'rating'},
                {data: 'review_title', name: 'review_title'},
                {data: 'comment', name: 'comment'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        $(document).on('click', '.deleteData', function(){
            var id = $(this).data('id');
            $('#confirmDelete').data('id', id);
        });

        $(document).on('click', '#confirmDelete', function(){
            var id = $(this).data('id');
            $.ajax({
                type: "DELETE",
                url: "{{ route('reviews.destroy', ':id') }}".replace(':id', id),
                success: function (data) {
                    // $('#confirmDeleteModal').modal('hide');
                    // $('.modal-backdrop').remove();
                    $('#table_Data').DataTable().ajax.reload(null, false); // Reload DataTable without resetting pagination
                    $('#alertMsg').show().delay(3000).fadeOut(); // Show the alert message- Show for 3 seconds and fade out
                    // window.location.reload();
                },
                error: function (xhr, status, error) {
                    console.error('Error deleting item:', error);
                }
            });
        });
    });
</script>

