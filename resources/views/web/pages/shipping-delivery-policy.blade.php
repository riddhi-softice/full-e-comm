@extends('web.layouts2.app')

<style>
    .list-view {
        list-style: circle !important;
        padding-left: 4rem !important;
    }
    .cap-title {
        font-size: 20px;
    }
</style>

@section('content')

<div class="page-header text-center"
    style="background-image: url('{{ asset('public/assets/images/page-header-bg.jpg') }}');">
    <div class="container">
        <h1 class="page-title">Shipping Policy<span></span></h1>
    </div><!-- End .container -->
</div><!-- End .page-header -->
<nav aria-label="breadcrumb" class="breadcrumb-nav">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('more-products') }}">Shop</a></li>
            <li class="breadcrumb-item active" aria-current="page">Shipping Policy</li>
        </ol>
    </div><!-- End .container -->
</nav><!-- End .breadcrumb-nav -->

<div class="page-content">
    <div class="container">
        <!-- <h2 class="title">Shipping Policy</h2> -->

        <p>Welcome to Reach Gems! We highly appreciate your visit and shopping at our store. Below is our Shipping
            Policy’s terms and conditions.</p>
        <br />
        <p><strong>Shipping Times:</strong> Please allow 3-4 business days for us to process and ship your order.
            Items may take time to ship out due to various factors such as processing, packaging, and carrier
            pickup. The time it takes for an item to ship out may vary depending on the specific product and current
            order volume. Rest assured, we strive to process orders as quickly as possible.<br>
            
        </p>
        <br />
        <p>During peak seasons or high-volume order periods, processing and shipping times may experience slight
            delays. In these cases, we will promptly notify you via email with any updates to your estimated
            delivery time. We appreciate your understanding and patience as we work to fulfill your order as quickly
            as possible during these busy times.</p>
        <br />
        <p>Once your order has been shipped, you can expect it to arrive within 7-15 business days. However, please
            keep in mind that shipping times may vary based on your location and other unforeseen circumstances
            beyond our control.<br>
            
        </p>
        <br />
        <p><strong>Customs, Duties, and Taxes:</strong> For international shipments, any customs duties, taxes, or
            other fees applied during or after shipping are the customer’s responsibility. Reach Gems is not liable for
            any additional charges that may be incurred upon arrival in the destination country.<strong></strong>
        </p>
        <br />
         <div class="heading">
            <h5 class="title">Order Tracking</h5>
            <!-- <p class="heading"><strong>Order Tracking</strong></p> -->
        </div>
        <p>Once your order has been shipped, you will receive a confirmation email containing tracking information.
            You can use this tracking number to monitor the status of your shipment and estimated delivery date.</p>
        <!-- <p><strong>Address Accuracy &amp; Changes</strong></p> -->
        <br/>
        <div class="heading">
            <h5 class="title">Address Accuracy &amp; Changes</h5>
        </div>
        <p>It is the responsibility of the buyer to make sure that the shipping address entered is correct. We do
            our best to speed up processing and shipping time, so there is always a small window to correct an
            incorrect shipping address (usually around 12 hours). Please contact us immediately if you believe you
            have provided an incorrect shipping address.<br>
            
        </p>
        <br>
        <p><strong>Damaged, Lost, or Missing Orders:</strong> We are <span
                style="text-decoration: underline;"><strong>not</strong></span> responsible for lost or stolen
            packages. If your tracking information states that your package was delivered to your address and you
            have not received it, please take the following steps before contacting us:</p>

        <ul class="list-view">
            <li>
                A lot of times packages can be delivered by someone on your mail route that isn’t the
                    “regular” mail delivery person, and they may not know that your packages should be left next to
                    the garage, on your front steps, just below your mailbox, etc. the way that your regular mail
                    delivery person takes care of things. Plenty of people find that even though USPS tracking says
                    delivered but no package was found in their mailbox it’s only because the package itself was
                    left at another doorstep, in the bushes, or set somewhere that they weren’t expecting.
            </li>
            <li>Check with neighbors, family members, or anyone who might have accepted the delivery on your behalf.
            </li>
            <li>Contact your local post office or carrier with your tracking number; they may be able to provide
                additional information about the delivery. If your package remains missing after these steps, please
                reach out to us within 15 days of the marked delivery date, and we will assist you further.</li>
        </ul>

        <p>All packaging materials and damaged goods must be saved in order to file a claim.        </p>
        <br>
        <p><em>If your order shows as delivered but has not been received by you, please reach out to us within 15
                days so we can ship a replacement. Requests coming in beyond that timeframe will unfortunately not
                be entertained.</em></p>
        <br>
        
        <!-- <p><strong>RECEIVED AN INCOMPLETE ORDER</strong></p> -->
        <div class="heading">
            <h5 class="title cap-title">RECEIVED AN INCOMPLETE ORDER</h5>
        </div>
        <p>If you've received an incomplete order or are missing items from your order, please email <strong>reachgemsandjewellery@gmail.com</strong> Include your
            name, order number, email address, a written explanation of the issue, and a picture of the item you
            received. In this instance, we will ship a replacement of the correct order to you. Refunds will not be
            issued. This would be required within<span> </span><strong>15 days</strong><span> </span>of the tracking
            show the order as delivered. Any request beyond<span> </span><strong>15 days</strong><span> </span>will
            unfortunately, not be entertained.</p>
        <br>
        <div class="heading">
            <h5 class="title cap-title">RECEIVED THE WRONG PRODUCT</h5>
        </div>
        <!-- <p><strong>RECEIVED THE WRONG PRODUCT</strong></p> -->
        <p>If you received the wrong product, please email<span> <strong>reachgemsandjewellery@gmail.com</strong><span>
            </span>Include your name, order number, email address, a written explanation of the issue, and a picture
            of the item you received. In this instance, we will ship a replacement of the correct order to you.
            Refunds will not be issued. This would be required within<span> </span><strong>15 days</strong><span>
            </span>of the tracking show the order as delivered. Any request beyond<span> </span><strong>15
                days</strong><span> </span>will unfortunately, not be entertained.</p>
        <!-- <p><strong>LATE ARRIVAL OF ORDER</strong></p> -->
         <br>
          <div class="heading">
            <h5 class="title cap-title">LATE ARRIVAL OF ORDER</h5>
        </div>
        <p>While we try our level best to ensure you receive your order within 5-7 days of your purchase, we cannot
            guarantee that due to the ongoing COVID-19 pandemic, recent hurricane and flooding. and other unforeseen
            circumstances that may affect shipping and inventory issues. We are unable to refund for items not being
            delivered by a specific date, special occasion, or holiday. Once an order has shipped we will no longer
            be able to edit or cancel the order.</p>
        <!-- <p>
        </p> -->

    </div><!-- End .container -->
</div><!-- End .page-content -->


@endsection
@section('javascript')
@endsection