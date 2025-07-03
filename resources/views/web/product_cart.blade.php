@extends('web.layouts2.app')
@section('content')

<div class="page-header text-center" style="background-image: url({{ asset('public/assets/images/page-header-bg.jpg') }}')">
    <div class="container">
        <h1 class="page-title">Shopping Cart<span>Shop</span></h1>
    </div><!-- End .container -->
</div><!-- End .page-header -->

<nav aria-label="breadcrumb" class="breadcrumb-nav">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Shop</a></li>
            <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
        </ol>
    </div><!-- End .container -->
</nav><!-- End .breadcrumb-nav -->

<div class="page-content">
    <div class="cart">
        <div class="container">
            <div class="row">

                <div class="col-lg-9">
                    
                        <table class="table table-cart table-mobile">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cartItems as $item)
                                    <tr>
                                        <td class="product-col">
                                            <div class="product">
                                                <figure class="product-media">
                                                    <a href="{{ route('product.show', $item->product->id) }}">
                                                        <img src="{{ $item->product->firstImage->path ? asset('public/assets/images/demos/demo-2/products/' . $item->product->firstImage->path) : asset('no-image.jpg') }}"
                                                            alt="Product image">
                                                    </a>
                                                </figure>
                                                <h3 class="product-title">
                                                    <a href="{{ route('product.show', $item->product->id) }}">{{ $item->product->name }}</a>
                                                </h3>
                                            </div>
                                        </td>
                                        <td class="price-col">{{ number_format($item->product->price, 2) }}</td>
                                        <td class="quantity-col">
                                            <div class="cart-product-quantity">
                                                <input type="number" class="form-control quantity-input"
                                                    value="{{ $item->quantity }}"
                                                    min="1" max="10"
                                                    data-price="{{ $item->product->price }}"
                                                    data-cart-id="{{ $item->id }}">
                                            </div>
                                            
                                        </td>
                                        <td class="total-col">
                                            {{ number_format($item->product->price * $item->quantity, 2) }}
                                        </td>
                                        <td class="remove-col">
                                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn-remove"><i class="icon-close"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5">Your cart is empty.</td></tr>
                                @endforelse
                            </tbody>
                        </table>

                    <!-- <div class="cart-bottom">
                        <a href="#" class="btn btn-outline-dark-2"><span>UPDATE CART</span><i class="icon-refresh"></i></a>
                    </div> -->

                </div><!-- End .col-lg-9 -->

                <aside class="col-lg-3">
                    <div class="summary summary-cart">
                        <h3 class="summary-title">Cart Total</h3><!-- End .summary-title -->

                        <table class="table table-summary">
                            <tbody>
                                <tr class="summary-subtotal">
                                    <td>Subtotal:</td>
                                    <td>{{ number_format($subtotal, 2) }}</td>
                                </tr>

                                <tr class="summary-shipping">
                                    <td>Shipping:</td>
                                    <td>&nbsp;</td>
                                </tr>

                                <tr class="summary-shipping-row">
                                    <td>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="free-shipping" name="shipping" class="custom-control-input">
                                            <label class="custom-control-label" for="free-shipping">Free Shipping</label>
                                        </div><!-- End .custom-control -->
                                    </td>
                                    <td>0.00</td>
                                </tr><!-- End .summary-shipping-row -->
                             
                                <tr class="summary-shipping-estimate">
                                    <td>Estimate for Your Country<br> <a href="{{ route('user.dashboard') }}">Change address</a></td>
                                    <td>&nbsp;</td>
                                </tr><!-- End .summary-shipping-estimate -->

                                <tr class="summary-total">
                                    <td>Total:</td>
                                    <td>{{ number_format($subtotal, 2) }}</td>
                                </tr><!-- End .summary-total -->
                            </tbody>
                        </table><!-- End .table table-summary -->

                        <a href="{{ route('order.add') }}" class="btn btn-outline-primary-2 btn-order btn-block">PROCEED TO CHECKOUT</a>
                    </div><!-- End .summary -->

                    <a href="{{ route('home') }}" class="btn btn-outline-dark-2 btn-block mb-3"><span>CONTINUE SHOPPING</span><i class="icon-refresh"></i></a>
                </aside><!-- End .col-lg-3 -->

            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .cart -->
</div><!-- End .page-content -->

@endsection
@section('javascript')

<script>
document.querySelectorAll('.quantity-input').forEach(input => {
    input.addEventListener('change', function () {
        const cartId = this.dataset.cartId;
        const quantity = parseInt(this.value) || 1;
        const price = parseFloat(this.dataset.price) || 0;
        
        // Update total in this row
        const row = this.closest('tr');
        const total = (quantity * price).toFixed(2);
        const totalCol = row.querySelector('.total-col');
        if (totalCol) {
            totalCol.textContent = `${total}`;
        }
        
        // Update subtotal and grand total
        let subtotal = 0;
        document.querySelectorAll('.quantity-input').forEach(input => {
            const quantity = parseInt(input.value) || 1;
            const price = parseFloat(input.dataset.price) || 0;

            if (!isNaN(price)) {
                subtotal += quantity * price;
            }
        });
        const subtotalEl = document.querySelector('.summary-subtotal td:last-child');
        const totalEl = document.querySelector('.summary-total td:last-child');
        if (subtotalEl) subtotalEl.textContent = `${subtotal.toFixed(2)}`;
        const shipping = parseFloat(document.querySelector('input[name="shipping"]:checked')?.value || 0);
        if (totalEl) totalEl.textContent = `${(subtotal + shipping).toFixed(2)}`;


        fetch("{{ route('cart.update') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": '{{ csrf_token() }}',
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                quantities: {
                    [cartId]: quantity
                }
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Optionally update subtotal/total on the page
                // location.reload(); // simplest way, or update DOM manually
            } else {
                alert(data.message || 'Update failed.');
            }
        })
        .catch(error => console.error("Error updating cart:", error));
    });
});
</script>

<!-- <script>
document.querySelectorAll('.quantity-input').forEach(input => {
    input.addEventListener('input', function () {
        const quantity = parseInt(this.value) || 1;
        const price = parseFloat(this.dataset.price) || 0;

        // Handle NaN or missing price
        if (isNaN(price)) return;

        const row = this.closest('tr');
        const total = (quantity * price).toFixed(2);

        // Update total in this row
        const totalCol = row.querySelector('.total-col');
        if (totalCol) {
            totalCol.textContent = `$${total}`;
        }

        updateSubtotal();
    });
});

function updateSubtotal() {
    let subtotal = 0;

    document.querySelectorAll('.quantity-input').forEach(input => {
        const quantity = parseInt(input.value) || 1;
        const price = parseFloat(input.dataset.price) || 0;

        if (!isNaN(price)) {
            subtotal += quantity * price;
        }
    });

    // Update subtotal and grand total
    const subtotalEl = document.querySelector('.summary-subtotal td:last-child');
    const totalEl = document.querySelector('.summary-total td:last-child');

    if (subtotalEl) subtotalEl.textContent = `$${subtotal.toFixed(2)}`;

    const shipping = parseFloat(document.querySelector('input[name="shipping"]:checked')?.value || 0);
    if (totalEl) totalEl.textContent = `$${(subtotal + shipping).toFixed(2)}`;
}
</script> -->

@endsection