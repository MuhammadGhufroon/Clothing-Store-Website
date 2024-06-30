@extends('frontend.landingpage.main')
@section('title', 'Shopping Cart Page')
@section('page', 'Shopping Cart Page')
@section('header')
    @include('frontend.landingpage.header')



    <!--================Home Banner Area =================-->
    <section class="banner_area">
      <div class="banner_inner d-flex align-items-center">
        <div class="container">
          <div
            class="banner_content d-md-flex justify-content-between align-items-center"
          >
            <div class="mb-3 mb-md-0">
              <h2>Cart</h2>
              <p>Review and manage items in your cart.</p>
            </div>
            <div class="page_link">
              <a href="/home-page">Home</a>
              <a href="/cart">Cart</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--================End Home Banner Area =================-->

<!--================Cart Area =================-->
<section class="cart_area">
    <div class="container">
        @if($orderDetails->isEmpty())
            <div class="alert alert-info">
                Your cart is empty. <a href="/category">Continue shopping</a>
            </div>
        @else
            <div class="cart_inner">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Image Product</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col" style="width: 150px;">Sub Total</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orderDetails as $orderDetail)
                                <tr>
                                    <td>
                                        <div class="media">
                                            <div class="d-flex">
                                                <img src="{{ $orderDetail->product->image1_url }}" alt="{{ $orderDetail->product->product_name }}" style="width: 100px; height: auto;" />
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p>{{ $orderDetail->product->product_name }}</p>
                                    </td>
                                    <td>
    @if($orderDetail->product->discounts->isNotEmpty())
        @php
            $discountedPrice = $orderDetail->product->price * (100 - $orderDetail->product->discounts->first()->percentage) / 100;
        @endphp
        <h5>Rp {{ number_format($discountedPrice, 0, ',', '.') }}</h5>

    @else
    <h5>Rp {{ number_format($orderDetail->product->price, 0, ',', '.') }}</h5>

    @endif
</td>
<td>
    <div class="product_count mt-4">
        <input type="number" name="qty" id="qty_{{ $orderDetail->id }}" min="1" max="999" value="{{ $orderDetail->quantity }}" title="Quantity:" class="input-text qty" onchange="updateQuantity({{ $orderDetail->id }}, this.value)">
        <button class="items-count" type="button" onclick="updateQuantity({{ $orderDetail->id }}, parseInt(document.getElementById('qty_{{ $orderDetail->id }}').value) + 1)">

        </button>
        <button class="items-count" type="button" onclick="updateQuantity({{ $orderDetail->id }}, parseInt(document.getElementById('qty_{{ $orderDetail->id }}').value) - 1)">

        </button>
    </div>
</td>
<td>
    @php
        $subtotal = $orderDetail->subtotal;
        if ($orderDetail->product->discounts->isNotEmpty()) {
            $discountedPrice = $orderDetail->product->price * (100 - $orderDetail->product->discounts->first()->percentage) / 100;
            $subtotal = $discountedPrice * $orderDetail->quantity;
        } else {
            $subtotal = $orderDetail->product->price * $orderDetail->quantity;
        }
    @endphp
    
    <h5 id="subtotal_{{ $orderDetail->id }}">Rp {{ $subtotal }}</h5>
</td>


                                    <td>
                                        <form id="delete-form-{{ $orderDetail->id }}" action="{{ route('cart.delete', $orderDetail->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $orderDetail->id }})"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="bottom_button">
                                <td colspan="4">
                                    <h5>Total</h5>
                                </td>
                                <td>
                                    <h5 id="totalAmount">Rp {{ $totalAmount }}</h5>
                                </td>
                            </tr>
                            <tr class="out_button_area">
                                <td colspan="6">
                                    <div class="checkout_btn_inner" style="display: flex; justify-content: space-between;">
                                        <a class="gray_btn" href="#">Update Details</a>
                                        <div style="display: flex; gap: 10px;">
                                            <a class="gray_btn" href="/category">Continue Shopping</a>
                                            
                                            @if(empty($customer->phone) || empty($customer->address1) || empty($customer->address2) || empty($customer->address3))
                                                <a class="main_btn" href="/profile/customer">Complete Profile for Checkout</a>
                                            @else
                                                <a class="main_btn" href="/checkout">Proceed to checkout</a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</section>
<!--================End Cart Area =================-->





    <!--================ start footer Area  =================-->
    <footer class="footer-area section_gap">
      <div class="container">
        <div class="row">
          <div class="col-lg-2 col-md-6 single-footer-widget">
            <h4>Top Products</h4>
            <ul>
              <li><a href="#">Managed Website</a></li>
              <li><a href="#">Manage Reputation</a></li>
              <li><a href="#">Power Tools</a></li>
              <li><a href="#">Marketing Service</a></li>
            </ul>
          </div>
          <div class="col-lg-2 col-md-6 single-footer-widget">
            <h4>Quick Links</h4>
            <ul>
              <li><a href="#">Jobs</a></li>
              <li><a href="#">Brand Assets</a></li>
              <li><a href="#">Investor Relations</a></li>
              <li><a href="#">Terms of Service</a></li>
            </ul>
          </div>
          <div class="col-lg-2 col-md-6 single-footer-widget">
            <h4>Features</h4>
            <ul>
              <li><a href="#">Jobs</a></li>
              <li><a href="#">Brand Assets</a></li>
              <li><a href="#">Investor Relations</a></li>
              <li><a href="#">Terms of Service</a></li>
            </ul>
          </div>
          <div class="col-lg-2 col-md-6 single-footer-widget">
            <h4>Resources</h4>
            <ul>
              <li><a href="#">Guides</a></li>
              <li><a href="#">Research</a></li>
              <li><a href="#">Experts</a></li>
              <li><a href="#">Agencies</a></li>
            </ul>
          </div>
          <div class="col-lg-4 col-md-6 single-footer-widget">
            <h4>Newsletter</h4>
            <p>You can trust us. we only send promo offers,</p>
            <div class="form-wrap" id="mc_embed_signup">
              <form target="_blank" action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01"
                method="get" class="form-inline">
                <input class="form-control" name="EMAIL" placeholder="Your Email Address" onfocus="this.placeholder = ''"
                  onblur="this.placeholder = 'Your Email Address '" required="" type="email">
                <button class="click-btn btn btn-default">Subscribe</button>
                <div style="position: absolute; left: -5000px;">
                  <input name="b_36c4fd991d266f23781ded980_aefe40901a" tabindex="-1" value="" type="text">
                </div>
  
                <div class="info"></div>
              </form>
            </div>
          </div>
        </div>
        <div class="footer-bottom row align-items-center">
          <p class="footer-text m-0 col-lg-8 col-md-12"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
          <div class="col-lg-4 col-md-12 footer-social">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-dribbble"></i></a>
            <a href="#"><i class="fa fa-behance"></i></a>
          </div>
        </div>
      </div>
    </footer>
    <!--================ End footer Area  =================-->


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>

<script>
    function confirmDelete(orderDetailId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + orderDetailId).submit();
            }
        })
    }
</script>


<script>
    function updateQuantity(orderDetailId, value) {
        let qty = parseInt(value);
        if (isNaN(qty) || qty < 1) {
            qty = 1;
        }

        // Send the updated quantity to the server
        fetch(`/update-cart-quantity/${orderDetailId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ quantity: qty })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                let newSubtotal;
                if (data.discountedPrice !== null && !isNaN(data.discountedPrice)) {
                    newSubtotal = data.discountedPrice * qty;
                } else {
                    newSubtotal = data.newSubtotal;
                }
                // Update subtotal directly in the HTML
                let subtotalElement = document.getElementById(`subtotal_${orderDetailId}`);
                if (subtotalElement) {
                    subtotalElement.innerText = `Rp ${newSubtotal}`;
                }
                // Update totalAmount
                document.getElementById('totalAmount').innerText = `Rp ${data.newTotalAmount}`;
            } else {
                alert('Failed to update quantity');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Check if there's a success message from the backend
    @if(session('success'))
        // Display SweetAlert with success message
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 1500
        });
    @endif
</script>



@endsection
