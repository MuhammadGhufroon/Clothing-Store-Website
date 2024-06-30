@extends('frontend.landingpage.main')
@section('title', 'Landing Page')
@section('page', 'Landing Page')
@section('header')
    @include('frontend.landingpage.header')

<style>
  .product-img {
    position: relative;
}

.category-name {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: #fff; 
    padding: 5px 10px; 
    border: 2px solid #ccc; 
    border-radius: 5px; 
    border-color: green;
}


</style>
  
<!--================Home Banner Area =================-->
<section class="home_banner_area mb-40">
    <div class="banner_inner d-flex align-items-center">
        <div class="container">
            <div class="banner_content row">
                <div class="col-lg-12">
                    <p class="sub text-uppercase">Fashion Collection</p>
                    <h3><span>Show</span> Your <br />Personal <span>Style</span></h3>
                    <h4>Discover trendy styles that express your individuality.</h4>
                      <a class="main_btn mt-40" href="/category">View Collection</a> 
                </div>
            </div>
        </div>
    </div>
</section>
<!--================End Home Banner Area =================-->




  <!-- Start feature Area -->
<section class="feature-area section_gap_bottom_custom">
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-md-6">
        <div class="single-feature">
          <a href="#" class="title">
            <i class="flaticon-money"></i>
            <h3>Money back guarantee</h3>
          </a>
          <p>Shop with confidence!</p>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="single-feature">
          <a href="#" class="title">
            <i class="flaticon-truck"></i>
            <h3>Free Delivery</h3>
          </a>
          <p>Enjoy free shipping on all orders!</p>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="single-feature">
          <a href="#" class="title">
            <i class="flaticon-support"></i>
            <h3>Always support</h3>
          </a>
          <p>We're here to help you, anytime!</p>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="single-feature">
          <a href="#" class="title">
            <i class="flaticon-blockchain"></i>
            <h3>Secure payment</h3>
          </a>
          <p>Your payments are safe with us!</p>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- End feature Area -->


  <!--================ Feature Product Area =================-->
  <section class="feature_product_area section_gap_bottom_custom">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <div class="main_title">
            <h2><span>Populer product</span></h2>
            <p>Explore our most popular products now</p>
          </div>
        </div>
      </div>

      <div class="row">
    @php $count = 0; @endphp
    @foreach($products_populer as $product)
        @if($count < 3)
            <div class="col-lg-4 col-md-6">
                <div class="single-product">
                    <div class="product-img">
                        <img class="img-fluid w-100" src="{{ asset($product->image1_url) }}" alt="{{ $product->product_name }}" />
                        <div class="p_icon">
                            <a href="/single-product/{{ $product->id }}"><i class="ti-eye"></i></a>
                            <a href="{{ route('wishlist-product.add') }}" onclick="event.preventDefault(); document.getElementById('wishlist-form-{{ $product->id }}').submit();"><i class="ti-heart"></i></a>
                                <!-- Form untuk wishlist -->
                                <form id="wishlist-form-{{ $product->id }}" action="{{ route('wishlist-product.add') }}" method="post" style="display: none;">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <!-- Tambahkan input lainnya sesuai dengan kebutuhan -->
                                </form>
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
                        <span class="category-name">{{ $product->category->category_name }}</span> 
                    </div>
                    <div class="product-btm">
                        <a href="#" class="d-block">
                            <h4>{{ $product->product_name }}</h4>
                        </a>
                        <div class="mt-3">
                                @if ($product->percentage)
                                    <span class="badge badge-success" style="font-size: 12px; color: white; font-weight: bold;">{{ $product->percentage }}% Off</span>
                                    <del>Rp {{ number_format($product->price, 0, ',', '.') }}</del><br>
                                    <span class="discounted-price" style="font-size: 18px;">Rp {{ number_format($product->discounted_price, 0, ',', '.') }}</span>
                                @else
                                <span style="font-size: 18px;">Rp {{ number_format($product->price, 0, ',', '.') }}</span><br>
                                @endif
                                @if ($product->category_discount_id)
                                    <div>
                                        Category Discount: {{ $product->category_name}}
                                    </div>
                                @endif
                            </div>
                    </div>
                </div>
            </div>
            @php $count++; @endphp
        @else
            @break
        @endif
    @endforeach
</div>

</section>

  <!--================ End Feature Product Area =================-->

  <!--================ Offer Area =================-->
  <section class="offer_area">
    <div class="container">
      <div class="row justify-content-center">
        <div class="offset-lg-4 col-lg-6 text-center">
          <div class="offer_content">
            <h3 class="text-uppercase mb-40">all men's collection</h3>
            <h2 class="text-uppercase">50% off</h2>
            <a href="/category" class="main_btn mb-20 mt-5">Discover Now</a>
            <p>Limited Time Offer</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--================ End Offer Area =================-->

  <!--================ Discount Product Area =================-->
  <section class="new_product_area section_gap_top section_gap_bottom_custom">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <div class="main_title">
            <h2><span>Discount products</span></h2>
            <p>Grab your favorite items at discounted prices now!</p>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-6">
          <div class="new_product">
            <h5 class="text-uppercase">collection of 2024</h5>
            <h3 class="text-uppercase">Men's summer t-shirt</h3>
            <div class="product-img">
              <img class="img-fluid" src="img/product/new-product/new-product1.png" alt="" />
            </div>
            <h4>Rp 350.000</h4>
            <h6><del>Rp 120.000</del></h6><br>
            <a href="/category" class="main_btn">Discover Now</a>
          </div>
        </div>

        <div class="col-lg-6 mt-5 mt-lg-0">
        <div class="row">
            @foreach($products_discount as $product)
            @if ($product->percentage && isset($product->discounted_price))
            <div class="col-lg-6 col-md-6">
                <div class="single-product">
                    <div class="product-img">
                        <img class="img-fluid w-100" src="{{ asset($product->image1_url) }}" alt="{{ $product->product_name }}" />
                        <div class="category-name">{{ $product->category->category_name }}</div> 
                        <div class="p_icon">
                            <a href="/single-product/{{ $product->id }}"><i class="ti-eye"></i></a>
                            <a href="{{ route('wishlist-product.add') }}" onclick="event.preventDefault(); document.getElementById('wishlist-form-{{ $product->id }}').submit();"><i class="ti-heart"></i></a>
                                <!-- Form untuk wishlist -->
                                <form id="wishlist-form-{{ $product->id }}" action="{{ route('wishlist-product.add') }}" method="post" style="display: none;">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <!-- Tambahkan input lainnya sesuai dengan kebutuhan -->
                                </form>
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
                    </div>
                    <div class="product-btm">
                        <a href="#" class="d-block">
                            <h4>{{ $product->product_name }}</h4>
                        </a>
                        <div class="mt-3">
                            <div>Discount {{ $product->discount_category_name }}</div>
                            <span class="badge badge-success" style="font-size: 12px; color: white; font-weight: bold;">{{ $product->percentage }}% Off</span>
                            <del>Rp {{ number_format($product->price, 0, ',', '.') }}</del><br>
                            <span class="discounted-price" style="font-size: 18px;">Rp {{ number_format($product->discounted_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>       
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--================ End Discount Product Area =================-->

  <!--================ Limited Product Area =================-->
  <section class="inspired_product_area section_gap_bottom_custom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="main_title">
                    <h2><span>Limited products</span></h2>
                    <p>Discover our exclusive limited edition products</p>
                </div>
            </div>
        </div>

        <div class="row">
    @php $count = 0; @endphp <!-- Inisialisasi variabel count untuk menghitung jumlah produk yang ditampilkan -->
    <!-- Tampilkan produk dengan kategori 'barang populer' -->
    @foreach($products_limited as $product)
        @if($count < 3) <!-- Batasi jumlah produk yang ditampilkan menjadi maksimal tiga -->
            <div class="col-lg-4 col-md-6">
                <div class="single-product">
                    <div class="product-img">
                        <img class="img-fluid w-100" src="{{ asset($product->image1_url) }}" alt="{{ $product->product_name }}" />
                        <div class="category-name">{{ $product->category->category_name }}</div> <!-- Pindahkan ini -->
                        <div class="p_icon">
                            <a href="/single-product/{{ $product->id }}"><i class="ti-eye"></i></a>
                            <a href="{{ route('wishlist-product.add') }}" onclick="event.preventDefault(); document.getElementById('wishlist-form-{{ $product->id }}').submit();"><i class="ti-heart"></i></a>
                                <!-- Form untuk wishlist -->
                                <form id="wishlist-form-{{ $product->id }}" action="{{ route('wishlist-product.add') }}" method="post" style="display: none;">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <!-- Tambahkan input lainnya sesuai dengan kebutuhan -->
                                </form>
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
                    </div>
                    <div class="product-btm">
                        <a href="#" class="d-block">
                            <h4>{{ $product->product_name }}</h4>
                        </a>
                        <div class="mt-3">
                                @if ($product->percentage)
                                    <span class="badge badge-success" style="font-size: 12px; color: white; font-weight: bold;">{{ $product->percentage }}% Off</span>
                                    <!-- Tampilkan harga diskon -->
                                    <del>Rp {{ $product->price }}</del><br>
                                    <span class="discounted-price" style="font-size: 18px;">Rp {{ number_format($product->discounted_price, 0, ',', '.') }}</span>
                                @else
                                <span style="font-size: 18px;">Rp {{ number_format($product->price, 0, ',', '.') }}</span><br>
                                @endif
                                @if ($product->category_discount_id)
                                    <div>
                                        Category Discount: {{ $product->category_name}}
                                    </div>
                                @endif
                            </div>
                    </div>
                </div>
            </div>
            @php $count++; @endphp <!-- Tingkatkan nilai variabel count setiap kali produk ditampilkan -->
        @else
            @break <!-- Hentikan loop foreach setelah tiga produk ditampilkan -->
        @endif
    @endforeach
</div>
</div>
</section>

  <!--================ End Limited Product Area =================-->



  <!--================ start footer Area  =================-->
<footer class="footer-area section_gap">
  <div class="container">
    <div class="row">
      <div class="col-lg-2 col-md-6 single-footer-widget">
        <h4>Featured Products</h4>
        <ul>
          <li><a href="/category">Men's Pants</a></li>
          <li><a href="/category">Sports Shoes</a></li>
          <li><a href="/category">Beautiful Dresses</a></li>
          <li><a href="/category">Modern Hijabs</a></li>
        </ul>
      </div>
      <div class="col-lg-2 col-md-6 single-footer-widget">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="#">About Us</a></li>
          <li><a href="/contact">Contact Us</a></li>
          <li><a href="#">Privacy Policy</a></li>
          <li><a href="#">Terms & Conditions</a></li>
        </ul>
      </div>
      <div class="col-lg-2 col-md-6 single-footer-widget">
        <h4>Features</h4>
        <ul>
          <li><a href="#">Free Shipping</a></li>
          <li><a href="#">Money Back Guarantee</a></li>
          <li><a href="#">Secure Payment</a></li>
        </ul>
      </div>
      <div class="col-lg-2 col-md-6 single-footer-widget">
        <h4>Information</h4>
        <ul>
          <li><a href="#">Blog</a></li>
          <li><a href="#">FAQ</a></li>
          <li><a href="#">Latest News</a></li>
        </ul>
      </div>
      <div class="col-lg-4 col-md-6 single-footer-widget">
        <h4>Subscribe to Newsletter</h4>
        <p>Get the latest promo info delivered straight to your email.</p>
        <div class="form-wrap" id="mc_embed_signup">
          <form target="_blank" action="#" method="get" class="form-inline">
            <input class="form-control" name="EMAIL" placeholder="Your Email" required="" type="email">
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
      <p class="footer-text m-0 col-lg-8 col-md-12">© <script>document.write(new Date().getFullYear());</script> All rights reserved. Ghufroon</p>
      <div class="col-lg-4 col-md-12 footer-social">
        <a href="#"><i class="fa fa-facebook"></i></a>
        <a href="#"><i class="fa fa-twitter"></i></a>
        <a href="#"><i class="fa fa-instagram"></i></a>
        <a href="#"><i class="fa fa-youtube"></i></a>
      </div>
    </div>
  </div>
</footer>
<!--================ End footer Area  =================-->



@endsection