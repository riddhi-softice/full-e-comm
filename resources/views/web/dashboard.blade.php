@extends('web.layouts2.app')
@section('content')

<div class="page-header text-center"
    style="background-image: url('{{ asset('public/assets/images/page-header-bg.jpg') }}');">

    <div class="container">
        <h1 class="page-title">My Account<span>Shop</span></h1>
    </div><!-- End .container -->
</div><!-- End .page-header -->

<nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('more-products') }}">Shop</a></li>
            <li class="breadcrumb-item active" aria-current="page">My Account</li>
        </ol>
    </div><!-- End .container -->
</nav><!-- End .breadcrumb-nav -->

<div class="page-content">
    <div class="dashboard">
        <div class="container">
            <div class="row">

                <aside class="col-md-4 col-lg-3">
                    <ul class="nav nav-dashboard flex-column mb-3 mb-md-0" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="tab-dashboard-link" data-toggle="tab" href="#tab-dashboard"
                                role="tab" aria-controls="tab-dashboard" aria-selected="true">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-orders-link" data-toggle="tab" href="#tab-orders" role="tab"
                                aria-controls="tab-orders" aria-selected="false">Orders</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" id="tab-downloads-link" data-toggle="tab" href="#tab-downloads"
                                role="tab" aria-controls="tab-downloads" aria-selected="false">Downloads</a>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link" id="tab-address-link" data-toggle="tab" href="#tab-address" role="tab"
                                aria-controls="tab-address" aria-selected="false">Adresses</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-account-link" data-toggle="tab" href="#tab-account" role="tab"
                                aria-controls="tab-account" aria-selected="false">Account Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.logout') }}">Sign Out</a>
                        </li>
                    </ul>
                </aside><!-- End .col-lg-3 -->

                <div class="col-md-8 col-lg-9">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab-dashboard" role="tabpanel" aria-labelledby="tab-dashboard-link">
                            <h4>Hello, {{ Auth::user()->name }}!</h4>
                            <p> (<a href="{{ route('user.logout') }}">Log out</a>)</p>
                            <!-- <p>Hello <span class="font-weight-normal text-dark">User</span> (not <span class="font-weight-normal text-dark">User</span>? <a href="#">Log out</a>)  -->
                            <br>
                                From your account dashboard you can view your <a href="#tab-orders" class="tab-trigger-link link-underline">recent orders</a>, manage your 
                                <a href="#tab-address" class="tab-trigger-link">shipping and billing addresses</a>, and 
                                <a href="#tab-account" class="tab-trigger-link">edit your password and account details</a>.
                            </p>
                        </div><!-- .End .tab-pane -->

                        <div class="tab-pane fade" id="tab-orders" role="tabpanel" aria-labelledby="tab-orders-link">
                            @if($data['order_count'] > 0)
                                <p class="mb-2">You have placed <strong>{{ $data['order_count'] }}</strong> {{ Str::plural('order', $data['order_count']) }}.</p>
                                <a href="{{ route('orders.history') }}" class="btn btn-outline-primary-2">
                                    <span>View Order History</span>
                                    <i class="icon-long-arrow-right"></i>
                                </a>
                            @else
                                <p class="mb-2">You haven’t placed any orders yet.</p>
                                <a href="{{ route('home') }}" class="btn btn-outline-primary-2">
                                    <span>Start Shopping</span>
                                    <i class="icon-long-arrow-right"></i>
                                </a>
                            @endif
                        </div>

                        <!-- <div class="tab-pane fade" id="tab-downloads" role="tabpanel"
                            aria-labelledby="tab-downloads-link">
                            <p>No downloads available yet.</p>
                            <a href="{{ route('home') }}" class="btn btn-outline-primary-2"><span>GO SHOP</span><i class="icon-long-arrow-right"></i></a>
                        </div> -->

                        <div class="tab-pane fade" id="tab-address" role="tabpanel" aria-labelledby="tab-address-link">
                            <p>The following addresses will be used on the checkout page by default.</p>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card card-dashboard">
                                        <div class="card-body">
                                            <h3 class="card-title">Shipping Address</h3>

                                            <p>{{ $data['user_details']['name'] }}<br>
                                                @if($data['user_details']['address'])
                                                {{$data['user_details']['address']['street'] ?? ''}}<br>
                                                {{$data['user_details']['address']['city'] ?? ''}},{{$data['user_details']['address']['state'] ?? ''}}<br>
                                                {{$data['user_details']['address']['country'] ?? ''}},{{$data['user_details']['address']['postal_code'] ?? ''}}<br>
                                                @endif
                                                {{ $data['user_details']['phone'] }}<br>
                                                {{ $data['user_details']['email'] }}<br>
                                                <!-- <a href="#">Edit <i class="icon-edit"></i></a> -->
                                            </p>
                                        </div><!-- End .card-body -->
                                    </div><!-- End .card-dashboard -->
                                </div><!-- End .col-lg-6 -->

                            </div><!-- End .row -->
                        </div><!-- .End .tab-pane -->

                        <div class="tab-pane fade" id="tab-account" role="tabpanel" aria-labelledby="tab-account-link">
                            <form action="{{ route('update.account') }}" method="POST">
                                @csrf

                                <label>Name *</label>
                                <input type="text" class="form-control" name="name"
                                    value="{{ old('name', $data['user_details']['name'] ) }}" required>

                                <label>Email address *</label>
                                <input type="text" class="form-control" disabled name="email"
                                    value="{{ old('email', $data['user_details']['email'] ) }}" required>

                                <label>Current password (leave blank to leave unchanged)</label>
                                <input type="password" class="form-control" name="old_password">

                                <label>New password (leave blank to leave unchanged)</label>
                                <input type="password" class="form-control" name="new_password">

                                <!-- <label>Confirm new password</label>
                                <input type="password" class="form-control mb-2" name="confirm_new_password"> -->

                                <button type="submit" class="btn btn-outline-primary-2">
                                    <span>SAVE CHANGES</span>
                                    <i class="icon-long-arrow-right"></i>
                                </button>
                            </form>
                        </div><!-- .End .tab-pane -->
                    </div>
                </div><!-- End .col-lg-9 -->

            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .dashboard -->
</div><!-- End .page-content -->

@endsection
@section('javascript')
@endsection