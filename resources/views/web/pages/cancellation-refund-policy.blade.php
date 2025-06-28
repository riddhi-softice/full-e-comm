@extends('web.layouts2.app')
<style>
.list-view {
    list-style: circle !important;
    padding-left: 4rem !important;
}
</style>
@section('content')

<div class="page-header text-center"
    style="background-image: url('{{ asset('public/assets/images/page-header-bg.jpg') }}');">
    <div class="container">
        <h1 class="page-title">Refund Policy<span></span></h1>
    </div><!-- End .container -->
</div><!-- End .page-header -->
<nav aria-label="breadcrumb" class="breadcrumb-nav">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('more-products') }}">Shop</a></li>
            <li class="breadcrumb-item active" aria-current="page">Refund Policy</li>
        </ol>
    </div><!-- End .container -->
</nav><!-- End .breadcrumb-nav -->

<div class="page-content">
    <div class="container">

        <p>Our 30-Day Satisfaction Guarantee ensures that if you are not completely happy with your purchase, you can
            reach out to us within 30 days of receiving your item, and we will work with you to make things right,
            either through a replacement or store credit.&nbsp;<strong><br></strong></p>
        <br>
        <p><strong>Lost or Missing Orders:</strong> Reach Gems is not responsible for lost or missing orders that are
            marked as delivered by the carrier. If your tracking information shows that your package was delivered, but
            you cannot locate it, please take the following steps before contacting us:</p>
        <br>
        <ul class="list-view">
            <li>Check with household members, neighbors, or building management who may have accepted the package on
                your behalf.</li>
            <li>Contact your local post office or carrier with the tracking number for additional details about the
                delivery.</li>
        </ul>
        <p>If you are unable to locate the package after these steps, please reach out to us, and we will do our best to
            assist you. However, please note that refunds are not issued for orders marked as delivered.</p>

        <br>
        <p><strong>Damaged Orders:</strong> If your order arrives damaged, please contact us within 15 days of receiving
            the package. Retain all packaging materials and provide clear photos of the damage, as these may be required
            to process a claim. After 15 days, we may not be able to provide a replacement.</p>
        <br>
        <p><strong>Incorrect Orders:</strong> If you received the wrong item, please email us at <a
                rel="noopener"><strong>reachgemsandjewellery@gmail.com</strong></a> within 15 days of
            delivery. Include your name, order number, a description of the issue, and a photo of the item received. We
            will send a replacement of the correct product to you. Refunds are not issued for incorrect orders.</p>
        <br>
        <p><strong>Late Arrival of Order:</strong> While we strive to deliver all orders promptly, delays may occur due
            to unforeseen circumstances. We are unable to guarantee delivery by a specific date or offer refunds for
            items that do not arrive by a particular date, such as holidays or special occasions. Once an order has
            shipped, we cannot edit or cancel it.</p>
        <br>
        <p><strong>Sale Items:</strong> Please note that we do not offer refunds or replacements on sale items.</p>
        <br>
        <p><strong>International Orders:</strong> All international orders are final sale and cannot be returned. In the
            rare case that an international order is lost in transit, a replacement will be issued.</p>
        <br>
        <p>If you have any questions or require further assistance, please don't hesitate to contact our customer
            service team at&nbsp;<a rel="noopener"><strong>reachgemsandjewellery@gmail.com</strong></a>. We
            are here to assist you and ensure your experience with Reach Gems is a positive one.</p>
        <br>
        <p>Thank you for choosing Reach Gems. We appreciate your support and look forward to serving you again in the
            future.</p>

        <br>
        <p>Sincerely,<br>Reach Gems</p>


    </div><!-- End .container -->
</div><!-- End .page-content -->

@endsection
@section('javascript')
@endsection