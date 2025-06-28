@extends('admin.layouts.app')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

@section('content')
    <div class="pagetitle">
        <h1>User Order </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">User Order </li>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title">User Order List</h5>
                        </div>
                        <table class="table data-table" id="table_Data">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Product</th>
                                    <th>Total Price</th>
                                    <th>Order Note</th>
                                    <th>Status</th>
                                    <th>Date</th>
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
            ordering: true,
            ajax: "{{ route('get_order_list') }}",
            columns: [
                {data: 'user_name', name: 'user_name'},
                {data: 'product_name', name: 'product_name'},
                {data: 'total', name: 'total'},
                {data: 'order_note', name: 'order_note'},
                {data: 'status', name: 'status'},
                {data: 'created_at', name: 'created_at',orderable: false, searchable: false}
            ]
        });
    });
</script>

<script>
    $(document).on('change', '.order-status-dropdown', function() {
        let orderId = $(this).data('id');
        let newStatus = $(this).val();

        $.ajax({
            url: 'change_order_status',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: orderId,
                status: newStatus
            },
            success: function(response) {
                alert('Status updated successfully!');
            },
            error: function() {
                alert('Failed to update status.');
            }
        });
    });
</script>

