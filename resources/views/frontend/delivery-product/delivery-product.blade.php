@extends('frontend.landingpage.main')
@section('title', 'Order Tracking Page')
@section('page', 'Order Tracking Page')
@section('header')

<style>
@import url('https://fonts.googleapis.com/css?family=Open+Sans&display=swap');

body {
  background-color: #eeeeee;
  font-family: 'Open Sans', serif;
}

.container {
  margin-top: 50px;
  margin-bottom: 50px;
}

.card {
  position: relative;
  display: flex;
  flex-direction: column;
  min-width: 0;
  word-wrap: break-word;
  background-color: #fff;
  background-clip: border-box;
  border: 1px solid rgba(0, 0, 0, 0.1);
  border-radius: 0.10rem;
}

.card-header:first-child {
  border-radius: calc(0.37rem - 1px) calc(0.37rem - 1px) 0 0;
}

.card-header {
  padding: 0.75rem 1.25rem;
  margin-bottom: 0;
  background-color: #fff;
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.track {
  position: relative;
  height: 7px;
  display: flex;
  margin-bottom: 60px;
  margin-top: 50px;
  background-color: #ddd;
}

.track .step {
  flex-grow: 1;
  width: 25%;
  margin-top: -18px;
  text-align: center;
  position: relative;
}

.track .step::before {
  content: '';
  position: absolute;
  width: 150%;
  height: 7px;
  top: 18px;
  left: -50%;
  background: #ddd;
  z-index: 0;
}

.track .step:first-child::before {
  left: 0;
  width: 50%;
}

.track .step.active::before {
  background: #00cc00; /* Warna garis hijau */
}

.track .step.active .icon {
  background: #00cc00; /* Warna latar belakang hijau untuk ikon aktif */
  color: #fff; /* Warna ikon putih */
}

.track .step .icon {
  display: inline-block;
  width: 40px;
  height: 40px;
  line-height: 40px;
  position: relative;
  border-radius: 100%;
  background: #ddd;
  z-index: 1;
}

.track .text {
  display: block;
  margin-top: 7px;
}

.itemside {
  position: relative;
  display: flex;
  width: 100%;
}

.itemside .aside {
  flex-shrink: 0;
}

.img-sm {
  width: 80px;
  height: 80px;
  padding: 7px;
}

ul.row, ul.row-sm {
  list-style: none;
  padding: 0;
}

.itemside .info {
  padding-left: 15px;
  padding-right: 7px;
}

.itemside .title {
  display: block;
  margin-bottom: 5px;
  color: #212529;
}

p {
  margin-top: 0;
  margin-bottom: 1rem;
}

.btn-warning {
  color: #ffffff;
  background-color: #71cd14;
  border-color: #71cd14;
  border-radius: 1px;
}

.btn-warning:hover {
  color: #ffffff;
  background-color: #00cc00;
  border-color: #00cc00;
  border-radius: 1px;
}

</style>

<!--================Home Banner Area =================-->
<section class="banner_area">
  <div class="banner_inner d-flex align-items-center">
    <div class="container">
      <div class="banner_content d-md-flex justify-content-between align-items-center">
        <div class="mb-3 mb-md-0">
          <h2>Order Tracking</h2>
          <p>This is track the status your order and delivery of your purchase.</p>
        </div>
        <div class="page_link">
          <a href="/">Home</a>
          <a href="/tracking">Order Tracking</a>
        </div>
      </div>
    </div>
  </div>
</section>
<!--================End Home Banner Area =================-->

<!--================Delivery Box Area =================-->
<div class="container">
    @if($deliveries->isEmpty())
        <div class="alert alert-info" role="alert">
            Your Order is empty. <a href="/category" class="alert-link">Continue shopping</a>.
        </div>
    @else
        @foreach($deliveries->groupBy('order_id') as $orderId => $orderDeliveries)
            <div class="mt-4"> <!-- Tambahkan jarak antara setiap container -->
                <article class="card">
                    <header class="card-header">RECEIPT CODE: {{ $orderId }}</header>
                    <div class="card-body">
                        @foreach($orderDeliveries as $delivery)
                            @php
                                $oneWeekAgo = \Carbon\Carbon::now()->subWeek();
                                if ($delivery->status === 'On the way' && $delivery->updated_at < $oneWeekAgo) {
                                    $delivery->status = 'Package has arrived';
                                    $delivery->save();
                                }
                            @endphp
                            <article class="card">
                            <div class="card-body row">
                                <div class="col"><strong>Status:</strong><br>{{ $delivery->status }}</div>
                                @php
                            // Periksa apakah nilai Estimated Delivery Date telah disimpan dalam session
                            $estimatedDeliveryDate = session('estimated_delivery_date');

                            // Jika belum disimpan, buat nilainya dan simpan dalam session
                            if (!$estimatedDeliveryDate) {
                                $estimatedDeliveryDate = \Carbon\Carbon::parse($delivery->shipping_date)->addDays(random_int(3, 5));
                                session(['estimated_delivery_date' => $estimatedDeliveryDate]);
                            }
                        @endphp

                        <div class="col">
                            <strong>Estimated Delivery Date:</strong><br>
                            {{ $estimatedDeliveryDate->toDateString() }}
                        </div>


        <div class="col"><strong>Courier By:</strong><br>{{ $delivery->courier }}</div>
        <div class="col"><strong>Tracking Code:</strong><br>{{ $delivery->tracking_code }}</div>
        
        <div class="col">
            <strong>Total Amount:</strong><br>
            @if ($delivery->payment) 
                Rp {{ number_format($delivery->payment->amount, 0, ',', '.') }}
            @else
                N/A <!-- Or any other fallback message indicating that payment data is not available -->
            @endif
        </div>
    </div>
</article>





                            @php
                                // Deklarasi variabel $statuses
                                $statuses = [
                                    'Order confirmed' => 'fa fa-check',
                                    'Package being packed' => 'fas fa-box',
                                    'On the way' => 'fa fa-truck',
                                    'Package has arrived' => 'fas fa-warehouse'
                                ];
                                $isActive = true; // Set isActive ke true di awal iterasi
                            @endphp

                            <div class="track">
                                @foreach($statuses as $status => $icon)
                                    <div class="step {{ $isActive ? 'active' : '' }}">
                                        <span class="icon"><i class="{{ $icon }}"></i></span>
                                        <span class="text">{{ $status }}</span>
                                    </div>
                                    @php
                                        $isActive = $delivery->status !== $status && $isActive; // Update isActive
                                    @endphp
                                @endforeach
                            </div>

                            <!-- Tombol untuk menerima paket -->
                            @if($delivery->status !== 'Package has arrived')
                                <form id="receive-package-form" action="{{ route('profile.receive-package') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <input type="hidden" id="delivery-status" value="{{ $delivery->status }}">
                                    <button type="button" onclick="checkPackageStatus()" class="btn btn-success">Packet Received</button>
                                </form>
                            @endif

                            <!-- Tombol untuk membatalkan order hanya saat status adalah 'Package being packed' -->
                            @if($delivery->status === 'Package being packed')
                                <form id="cancel-order-form-{{ $orderId }}" action="{{ route('order.cancel', $orderId) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="button" onclick="showCancelConfirmation({{ $orderId }})" class="btn btn-danger">Cancel Order</button>
                                </form>
                            @endif

                            <!-- Tombol untuk menghapus riwayat pesanan hanya saat status adalah 'Package has arrived' -->
                            @if($delivery->status === 'Package has arrived')
                                <form id="delete-history-form-{{ $delivery->id }}" action="{{ route('delivery.delete-history', $delivery->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="button" onclick="showDeleteConfirmation({{ $delivery->id }})" class="btn btn-danger">Delete Order History</button>
                                </form>
                            @endif
                        @endforeach

                        <hr>
                    </div>
                </article>
            </div>
        @endforeach
    @endif

    <!-- Tombol untuk kembali ke halaman kategori -->
    <a href="/category" class="btn btn-warning mt-4" data-abc="true"><i class="fa fa-chevron-left"></i> Back to Shop Page</a>
</div>
<!--================End Delivery Box Area =================-->





<!--================ Start footer Area  =================-->
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



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    // Function to check package status before showing confirmation
    function checkPackageStatus() {
        var status = document.getElementById('delivery-status').value;
        if (status === 'Package being packed') {
            Swal.fire({
                title: 'Warning',
                text: "The package is still being packed. You cannot mark it as received yet.",
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        } else {
            showConfirmation();
        }
    }

    // Function to show SweetAlert confirmation for receiving package
    function showConfirmation() {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to mark the package as received?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Receive Package!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // If user confirms, submit the form after a 2-second delay
                setTimeout(function(){
                    document.getElementById('receive-package-form').submit();
                }, 2000);

                // Show success message after the form is submitted
                setTimeout(function(){
                    Swal.fire(
                        'Received!',
                        'The package has been marked as received.',
                        'success'
                    );
                }, 1500);
            }
        });
    }

    // Function to show SweetAlert confirmation for cancelling order
    function showCancelConfirmation(orderId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you really want to cancel this order?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Cancel Order!',
            cancelButtonText: 'No, Keep Order'
        }).then((result) => {
            if (result.isConfirmed) {
                // If user confirms, submit the cancel order form
                document.getElementById('cancel-order-form-' + orderId).submit();

                // Show success message after the form is submitted
                Swal.fire(
                    'Cancelled!',
                    'The order has been cancelled.',
                    'success'
                );
            }
        });
    }

    // Function to show SweetAlert confirmation for deleting order history
    function showDeleteConfirmation(deliveryId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you really want to delete this order history?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete History!',
            cancelButtonText: 'No, Keep History'
        }).then((result) => {
            if (result.isConfirmed) {
                // If user confirms, submit the delete order history form
                document.getElementById('delete-history-form-' + deliveryId).submit();

                // Show success message after the form is submitted
                Swal.fire(
                    'Deleted!',
                    'The order history has been deleted.',
                    'success'
                );
            }
        });
    }
</script>



@endsection
