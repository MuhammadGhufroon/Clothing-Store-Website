@extends('frontend.landingpage.main')
@section('title', 'Product Category Page')
@section('page', 'Product Category Page')
@section('header')
    @include('frontend.landingpage.header')

<style>
  ul.list li a.active::before {
    background-color: green; /* Ganti warna lingkaran menjadi hijau saat link aktif */
}

  ul.list li a.active::before {
    background-color: green; /* Ganti warna lingkaran menjadi hijau saat link aktif */
}

.price_filter {
        margin-top: 20px;
    }

    .price_slider_amount {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 10px;
        flex-wrap: wrap; /* Mengizinkan item untuk meluncur ke baris baru saat perlu */
    }

    .label-input {
        display: flex;
        align-items: center;
        margin-bottom: 10px; /* Jarak antara item */
    }

    .label-input span {
        margin-right: 5px;
    }

    input[type="text"] {
        width: 100px;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        outline: none;
    }

    .btn-filter {
        padding: 10px 20px;
        background-color: #4CAF50; /* Warna hijau */
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-left: 5px;
        margin-top: 5px;
    }

    .btn-filter:hover {
        background-color: #45a049; /* Warna hijau yang sedikit lebih gelap saat hover */
    }
 
     /* Style untuk pesan pop-up */
     .custom-alert {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        z-index: 9999;
    }

    .custom-alert h2 {
        margin-bottom: 10px;
        font-size: 20px;
        color: #333;
    }

    .custom-alert p {
        margin-bottom: 10px;
        font-size: 16px;
        color: #666;
    }

    .custom-alert button {
        padding: 10px 20px;
        background-color: #4CAF50;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .custom-alert button:hover {
        background-color: #45a049;
    }
    
    .product-img {
    position: relative;
}

.category-name {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: rgba(255, 255, 255, 0.6); /* Warna latar belakang transparan */
    padding: 5px 10px; 
    border: 2px solid #ccc; 
    border-radius: 5px; 
    border-color: green;
}


.filter-bar {
    margin-top: 20px;
    text-align: center;
}

.pagination {
    margin-top: 20px;
    display: inline-block;
}

.pagination a {
    color: #71cd14;
    float: left;
    padding: 8px 16px;
    text-decoration: none;
    transition: background-color .3s;
    border-radius: 3px;
    margin: 0 2px;
}

.pagination a.active {
    background-color: #71cd14;
    color: white;
}

.pagination a:hover:not(.active) {
    background-color: #71cd14;
    color: white;
}

.pagination .prev-arrow,
.pagination .next-arrow {
    color: #71cd14;
    padding: 8px;
    text-decoration: none;
}

.pagination .dot-dot {
    pointer-events: none;
}

.pagination {
        display: flex;
        justify-content: center;
        padding-left: 0;
        list-style: none;
    }

    .page-item {
        margin: 0 5px; /* Memberikan jarak antar angka */
    }

    .page-link {
        display: block;
        padding: 0.5rem 0.75rem;
        margin-left: -1px;
        line-height: 1.25;
        color: #007bff;
        background-color: #fff;
        border: 1px solid #dee2e6;
        text-decoration: none;
    }

    .page-item.active .page-link {
        z-index: 1;
        color: #fff;
        background-color: #71cd14;
        border-color: #71cd14;
    }

    .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        background-color: #fff;
        border-color: #dee2e6;
    }

</style>

    <!--================Home Banner Area =================-->
    <section class="banner_area">
      <div class="banner_inner d-flex align-items-center">
        <div class="container">
          <div class="banner_content d-md-flex justify-content-between align-items-center">
            <div class="mb-3 mb-md-0">
              <h2>Product Category</h2>
              <p>Explore our wide range of product categories.</p>
            </div>
            <div class="page_link">
              <a href="/home-page">Home</a>
              <a href="/category">Product Category</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--================End Home Banner Area =================-->

    <!--================Category Product Area =================-->

    <section class="cat_product_area section_gap">
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-lg-9">
                <div class="product_top_bar">
                    <div class="left_dorp">
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchInput" placeholder="Search Product Name">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="searchButton"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    </div>
                    </div>

<script>
    // Fungsi untuk melakukan pencarian
    function searchProducts() {
        // Ambil nilai kata kunci dari input
        var keyword = document.getElementById("searchInput").value;

        // Lakukan pengalihan ke URL pencarian dengan menambahkan parameter query
        window.location.href = "{{ route('category.search') }}?keyword=" + keyword;
    }

    // Ketika tombol pencarian diklik
    document.getElementById("searchButton").addEventListener("click", function() {
        searchProducts();
    });

    // Ketika tombol Enter ditekan di dalam input pencarian
    document.getElementById("searchInput").addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            searchProducts();
        }
    });
</script>


<div class="latest_product_inner">
    <div class="row">
        @if ($products->isNotEmpty())
            @foreach($products as $product)
                <div class="col-lg-4 col-md-6">
                    <div class="single-product" data-price="{{ $product->price }}" data-product-id="{{ $product->id }}" data-image="{{ asset($product->image1_url) }}" data-name="{{ $product->product_name }}">
                        <div class="product-img img-container image-wrapper">
                            <a href="/single-product/{{ $product->id }}">
                                <img class="card-img" src="{{ asset($product->image1_url) }}" alt="{{ $product->product_name }}" style="max-width: 100%; max-height: 100%;">
                            </a>
                            <!-- Tombol dan tautan lainnya -->
                            <div class="p_icon">
                                <a href="/single-product/{{ $product->id }}"><i class="ti-eye"></i></a>
                            <!-- Tombol favorit -->
                                <form id="wishlist-form-{{ $product->id }}" action="{{ route('wishlist-product.add') }}" method="POST" style="display: none;">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                </form>
                                <a href="#" onclick="event.preventDefault(); document.getElementById('wishlist-form-{{ $product->id }}').submit();"><i class="ti-heart"></i></a>

                            <!-- Tombol keranjang belanja -->
                                <form id="add-to-cart-form-{{ $product->id }}" action="{{ route('add-to-cart') }}" method="POST" style="display: none;">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="price" value="{{ $product->discounted_price ?: $product->price }}">
                                    <input type="hidden" name="hasDiscount" value="{{ $product->discounted_price ? '1' : '0' }}">
                                </form>
                                <a href="#" onclick="event.preventDefault(); document.getElementById('add-to-cart-form-{{ $product->id }}').submit();">
                                    <i class="ti-shopping-cart"></i>
                                </a>

                            </div>
                            <!-- Nama kategori -->
                            <span class="category-name" style="font-family: Arial, sans-serif; font-size: 14px; font-weight: bold; color: #555;">{{ $product->category->category_name }}</span>
                        </div>
                        <!-- Informasi produk -->
                        <div class="product-btm">
                            <a href="#" class="d-block">
                                <h4>{{ $product->product_name }}</h4>
                            </a>
                            <div class="mt-3">
                            @if ($product->percentage && isset($product->discounted_price))
                                <!-- Diskon dan harga -->
                                <div>Discount {{ $product->discount_category_name }}</div>
                                <span class="badge badge-success" style="font-size: 12px; color: white; font-weight: bold;">{{ $product->percentage }}% Off</span>
                                <del>Rp {{ number_format($product->price, 0, ',', '.') }}</del><br>
                                <span class="discounted-price" style="font-size: 18px;">Rp {{ number_format($product->discounted_price, 0, ',', '.') }}</span>
                            @else
                                <!-- Harga normal -->
                                <span class="price" style="font-size: 18px;">Rp {{ number_format($product->price, 0, ',', '.') }}</span><br>

                            @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <!-- Pesan jika tidak ada produk -->
            <p>No products found</p>
        @endif   
    </div>

    <!-- Pagination -->
    <div class="filter-bar d-flex flex-wrap align-items-center justify-content-center">
        {{ $products->links('vendor.pagination.default') }}
    </div>
</div>
      


<script>
    function addToWishlist(productId) {
        // Ambil customer_id dari session atau dari Auth jika tersedia
        let customerId = '{{ Auth::guard("customers")->id() }}';

        // Pastikan customerId dan productId tidak kosong
        if (customerId && productId) {
            // Setel nilai product_id_input dan customer_id_input
            document.getElementById('product_id_input').value = productId;
            document.getElementById('customer_id_input').value = customerId;
            
            // Kirim formulir
            document.getElementById('addToWishlistForm').submit();
        } else {
            // Handle jika customerId atau productId kosong
            console.error('customerId or productId is empty');
        }
    }
</script>


</div>
        <div class="col-lg-3">
            <div class="left_sidebar_area">
                
            <aside class="left_widgets p_filter_widgets product_categories">
    <div class="l_w_title">
        <h3>Product Categories</h3>
    </div>
    <div class="widgets_inner">
        <ul class="list">
            <li>
                <a href="{{ route('category.index') }}" class="{{ !$categoryId && !$discountCategoryId ? 'active' : '' }}">All Products</a>
            </li>
            @foreach($categories as $cat)
                <li>
                    <a href="{{ route('category.index', ['category_id' => $cat->id]) }}" class="{{ $cat->id == $categoryId ? 'active' : '' }}">{{ $cat->category_name }}</a>
                </li>
            @endforeach
        </ul>
    </div>
</aside>

<aside class="left_widgets p_filter_widgets discount_categories">
    <div class="l_w_title">
        <h3>Discount Categories</h3>
    </div>
    <div class="widgets_inner">
        <ul class="list">
            @foreach($discountCategories as $discountCat)
                <li>
                    <a href="{{ route('category.index', ['discount_category_id' => $discountCat->id]) }}" class="{{ $discountCat->id == $discountCategoryId ? 'active' : '' }}">{{ $discountCat->category_name }}</a>
                </li>
            @endforeach
        </ul>
    </div>
</aside>
         
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
</section>


    <!--================End Category Product Area =================-->

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

   
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@parent
@if(Auth::guard('customers')->check() && !session('loginPopupDisplayed'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Login Successful!',
                text: 'Welcome back, {{ Auth::guard("customers")->user()->name }}!',
                showConfirmButton: false,
                timer: 1500 
            });
        });
    </script>
    <?php session(['loginPopupDisplayed' => true]); ?>
@endif



@endsection
