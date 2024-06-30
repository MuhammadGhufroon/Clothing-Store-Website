@extends('frontend.landingpage.main')
@section('title', 'Wishlist Page')
@section('page', 'Wishlist Page')
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
              <h2>Wishlist</h2>
              <p>Discover your favorite items to add to your wishlist.</p>
            </div>
            <div class="page_link">
              <a href="/home-page">Home</a>
              <a href="/wishlist-product">Wishlist</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--================End Home Banner Area =================-->

<!--================Wishlist Area =================-->
<section class="cart_area">
    <div class="container">
        @if($wishlistProducts->isEmpty())
        <div class="alert alert-info">
            Your wishlist is empty. <a href="/category">Continue shopping</a>
        </div>
        @else
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered-top" style="border-collapse: collapse; text-align: center; vertical-align: middle;">
                            <thead>
                                <tr>
                                    <th style="border: 0;">Image Product</th>
                                    <th style="border: 0;">Product Name</th>
                                    <th style="border: 0;">Price</th>
                                    <th style="border: 0;">Add to Cart</th>
                                    <th style="border: 0;">Delete Wishlist</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($wishlistProducts as $wishlistProduct)
                                <tr>
                                    <td>
                                        <div class="media justify-content-center">
                                            <div class="d-flex">
                                                <img src="{{ $wishlistProduct->product->image1_url }}" alt="{{ $wishlistProduct->product->product_name }}" style="width: 100px; height: auto;" />
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="media-body">
                                            <p>
                                                {{ $wishlistProduct->product->product_name }}
                                            </p>
                                        </div>
                                    </td>
                                    <td>
                                        <h5>Rp {!! $wishlistProduct->product->price !!}</h5>
                                    </td>
                                    <td>
                                        <form action="{{ route('add-to-cart-from-wishlist', $wishlistProduct) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success"><i class="fa-solid fa-plus"></i></button>
                                        </form>
                                    </td>
                                    <td>
                                        <form id="delete-form-{{ $wishlistProduct->id }}" action="{{ route('wishlist-product.destroy', $wishlistProduct->id) }}" method="POST" class="mx-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger delete-wishlist" data-id="{{ $wishlistProduct->id }}"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Tambahkan tombol "Proceed All to Order" -->
                    <div class="checkout_btn_inner text-right">
                        <a class="gray_btn" href="/category">Continue Shopping</a>
                        <form action="{{ route('proceed-all-to-cart') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="main_btn">Proceed All to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

<!--================End Wishlist Area =================-->



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
 

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    // Menggunakan event delegate untuk menangani klik tombol delete
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('delete-wishlist')) {
            // Menampilkan Sweet Alert untuk konfirmasi
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                // Jika pengguna mengonfirmasi penghapusan
                if (result.isConfirmed) {
                    // Submit form untuk menghapus item wishlist
                    var formId = e.target.closest('form').getAttribute('id');
                    document.getElementById(formId).submit();
                }
            });
        }
    });
</script>

<!-- Di wishlist-product.blade.php -->
@if(session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 1500
        });
    </script>
@endif

<script>
    function increaseQuantity(id) {
        var qtyInput = document.getElementById('qty_' + id);
        var totalElement = document.getElementById('total_' + id);
        var price = parseFloat(totalElement.innerText); // Harga awal
        var qty = parseInt(qtyInput.value); // Jumlah awal

        qtyInput.value = qty + 1; // Tambah jumlah
        totalElement.innerText = (price * (qty + 1)).toFixed(2); // Perbarui total
    }

    function decreaseQuantity(id) {
        var qtyInput = document.getElementById('qty_' + id);
        var totalElement = document.getElementById('total_' + id);
        var price = parseFloat(totalElement.innerText); // Harga awal
        var qty = parseInt(qtyInput.value); // Jumlah awal

        if (qty > 1) {
            qtyInput.value = qty - 1; // Kurangi jumlah jika lebih dari 1
            totalElement.innerText = (price * (qty - 1)).toFixed(2); // Perbarui total
        }
    }

    function calculateTotal(id) {
        var qtyInput = document.getElementById('qty_' + id);
        var totalElement = document.getElementById('total_' + id);
        var price = parseFloat(totalElement.innerText); // Harga awal
        var qty = parseInt(qtyInput.value); // Jumlah awal

        totalElement.innerText = (price * qty).toFixed(2); // Perbarui total
    }
</script>

@endsection
