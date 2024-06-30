<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
</head>
<body>

@extends('frontend.landingpage.main')
@section('title', 'Product Checkout Page')
@section('page', 'Product Checkout Page')
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
              <h2>Product Checkout</h2>
              <p>Complete your purchase securely and efficiently.</p>
            </div>
            <div class="page_link">
              <a href="/">Home</a>
              <a href="/checkout">Product Checkout</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--================End Home Banner Area =================-->

<!--================Checkout Area =================-->
<section class="checkout_area section_gap">
    <div class="container">
        <div class="returning_customer">
            <div class="check_title">
                <h2>Returning Customer? <a href="/customer/login">Click here to login</a></h2>
            </div>
            <p>If you have shopped with us before, please see your details in the boxes below. If you are a new customer, please fill your data before payment.</p>
        </div>

        <div class="billing_details">
            <div class="row">
                <div class="col-lg-7">
                    <h3>Billing Details</h3>
                    <!-- Customer Details Form -->
                    <form class="row contact_form" novalidate="novalidate">
                        <div class="col-md-6 form-group p_star">
                            <label for="name">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $customer->name }}" readonly />
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <label for="phone">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ $customer->phone }}" readonly />
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $customer->email }}" readonly />
                        </div>
                        <div class="col-md-12 form-group p_star">
                            <label for="add1">Home Address</label>
                            <input type="text" class="form-control" id="add1" name="address1" value="{{ $customer->address1 }}" readonly />
                        </div>
                        <div class="col-md-12 form-group p_star">
                            <label for="add2">City</label>
                            <input type="text" class="form-control" id="add2" name="address2" value="{{ $customer->address2 }}" readonly />
                        </div>
                        <div class="col-md-12 form-group p_star">
                            <label for="add3">Province</label>
                            <input type="text" class="form-control" id="add3" name="address3" value="{{ $customer->address3 }}" readonly />
                        </div>
                    </form>
                </div>

                <div class="col-lg-5">
                    <div class="order_box">
                        <h2>Your Order</h2>
                        <ul class="list">
                            <li>
                                <a>Product <span>Sub Total</span></a>
                            </li>
                            @php
                                $grandTotal = 0; // Inisialisasi grandTotal
                            @endphp
                            @foreach($cartItems as $item)
                                <li>
                                    <a>{{ $item->product->product_name }} 
                                        <span class="middle">x {{ $item->quantity }}</span> 
                                        <span class="last">Rp 
                                            @if($item->product->discounts->isNotEmpty())
                                                @php
                                                    $discountedPrice = $item->product->price * (100 - $item->product->discounts->first()->percentage) / 100;
                                                    $subtotal = $discountedPrice * $item->quantity;
                                                @endphp
                                                {{ number_format($subtotal, 2) }}
                                                @php
                                                    $grandTotal += $subtotal; // Menambahkan subtotal ke grandTotal
                                                @endphp
                                            @else
                                                {{ number_format($item->subtotal, 2) }}
                                                @php
                                                    $grandTotal += $item->subtotal; // Menambahkan subtotal ke grandTotal
                                                @endphp
                                            @endif
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <!-- Tampilkan biaya pengiriman di halaman checkout -->
                        <ul class="list list_2">
                        <li>
                                <a>Shipping Cost <span>Rp {{ number_format($shippingCost, 0, ',', '.') }}</span></a>
                            </li>


                            <!-- Menambahkan biaya pengiriman ke total -->
                            <li>
                                <a>Total 
                                    <span>
                                        Rp 
                                        {{ number_format($grandTotal + $shippingCost, 2) }} <!-- Menambahkan grandTotal dan biaya pengiriman -->
                                    </span>
                                </a>
                            </li>
                        </ul>

                        <div class="order_details">
                            <ul class="list">
                                <li><a>Order Date: <span>{{ $order_date }}</span></a></li>
                            </ul>
                        </div>
                        <br>

                        <div class="col-md-12 form-group">
                            <label for="courier">Select Courier:</label><br>
                            <select class="form-control" id="courier" name="courier">
                                <option value="jne">JNE</option>
                                <option value="pos">POS Indonesia</option>
                                <option value="tiki">TIKI</option>
                            </select>
                        </div>
                        <br><br>

                        <input type="hidden" id="order-id" value="{{ $order_id }}">
                        <a class="main_btn" id="pay-button" style="color: white;" onclick="proceedToPayment()">Buy Now</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================End Checkout Area =================-->






    <!--================ start footer Area  =================-->
    <footer class="footer-area section_gap">
      <div class="container">
        <div class="row">
          <div class="col-lg-2 col-md-6 single-footer-widget">
            <h4>Top Products</h4>
            <ul>
              <li><a>Managed Website</a></li>
              <li><a>Manage Reputation</a></li>
              <li><a>Power Tools</a></li>
              <li><a>Marketing Service</a></li>
            </ul>
          </div>
          <div class="col-lg-2 col-md-6 single-footer-widget">
            <h4>Quick Links</h4>
            <ul>
              <li><a>Jobs</a></li>
              <li><a>Brand Assets</a></li>
              <li><a>Investor Relations</a></li>
              <li><a>Terms of Service</a></li>
            </ul>
          </div>
          <div class="col-lg-2 col-md-6 single-footer-widget">
            <h4>Features</h4>
            <ul>
              <li><a>Jobs</a></li>
              <li><a>Brand Assets</a></li>
              <li><a>Investor Relations</a></li>
              <li><a>Terms of Service</a></li>
            </ul>
          </div>
          <div class="col-lg-2 col-md-6 single-footer-widget">
            <h4>Resources</h4>
            <ul>
              <li><a>Guides</a></li>
              <li><a>Research</a></li>
              <li><a>Experts</a></li>
              <li><a>Agencies</a></li>
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
            <a><i class="fa fa-facebook"></i></a>
            <a><i class="fa fa-twitter"></i></a>
            <a><i class="fa fa-dribbble"></i></a>
            <a><i class="fa fa-behance"></i></a>
          </div>
        </div>
      </div>
    </footer>
    <!--================ End footer Area  =================-->




<!-- Midtrans Snap.js -->
<script type="text/javascript"
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}"></script>
<!-- Note: replace with src="https://app.midtrans.com/snap/snap.js" for Production environment -->
<div id="snap-container"></div>

<script type="text/javascript">
    function proceedToPayment() {
        var courier = document.getElementById("courier").value;
        var orderId = document.getElementById("order-id").value;

        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                updateOrderAndDeliveryStatus(orderId, 'Paid', 'Package being packed', courier)
                    .then(data => {
                        console.log("Order and Delivery status updated:", data);
                        if (data.success) {
                            createPayment(orderId, 'E-wallet', {{ $total }})
                                .then(paymentData => {
                                    console.log("Payment created:", paymentData);
                                    if (paymentData.success) {
                                        Swal.fire({
                                            title: 'Payment Success!',
                                            icon: 'success',
                                            showCancelButton: false,
                                            confirmButtonText: 'OK'
                                        }).then((result) => {
                                            window.location.href = '/delivery-product';
                                        });
                                    } else {
                                        showError('Error creating payment record: ' + paymentData.error);
                                    }
                                })
                                .catch(error => showError('Error creating payment record. Please try again.', error));
                        } else {
                            showError('Error updating order status: ' + data.error);
                        }
                    })
                    .catch(error => showError('Error updating order status. Please try again.', error));
            },
            onPending: function(result) {
                Swal.fire({
                    title: 'Waiting for your payment...',
                    icon: 'info',
                    showCancelButton: false,
                    confirmButtonText: 'OK'
                });
            },
            onError: function(result) {
                Swal.fire({
                    title: 'Payment Failed!',
                    text: 'Please try again later.',
                    icon: 'error',
                    showCancelButton: false,
                    confirmButtonText: 'OK'
                });
            },
            onClose: function() {
                Swal.fire({
                    title: 'Payment Cancelled!',
                    text: 'You closed the popup without finishing the payment.',
                    icon: 'info',
                    showCancelButton: false,
                    confirmButtonText: 'OK'
                });
            }
        });
    }

    function updateOrderAndDeliveryStatus(orderId, orderStatus, deliveryStatus, courier) {
        return fetch(`/checkout/update-order-delivery-status/${orderId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                order_status: orderStatus,
                delivery_status: deliveryStatus,
                courier: courier
            })
        }).then(response => response.json());
    }

    function createPayment(orderId, paymentMethod, amount) {
        return fetch(`/checkout/create-payment`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                order_id: orderId,
                payment_method: paymentMethod,
                amount: amount,
            })
        }).then(response => response.json());
    }

    function showError(message, error) {
        console.error(message, error);
        Swal.fire({
            title: 'Error!',
            text: message,
            icon: 'error',
            showCancelButton: false,
            confirmButtonText: 'OK'
        });
    }
</script>








</body>
</html>
@endsection