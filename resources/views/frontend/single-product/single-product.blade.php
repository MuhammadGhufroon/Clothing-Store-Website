@extends('frontend.landingpage.main')
@section('title', 'Product Detail Page')
@section('page', 'Product Detail Page')
@section('header')
    @include('frontend.landingpage.header')

<style>
  .tab-content p {
        word-wrap: break-word; 
        overflow-wrap: break-word; 
    }

</style>

    <!--================Home Banner Area =================-->
    <section class="banner_area">
      <div class="banner_inner d-flex align-items-center">
        <div class="container">
          <div
            class="banner_content d-md-flex justify-content-between align-items-center"
          >
            <div class="mb-3 mb-md-0">
              <h2>Product Details</h2>
              <p>Explore the detailed information about our products.</p>
            </div>
            <div class="page_link">
              <a href="/home-page">Home</a>
              <a href="/category">Product Category</a>
              <a href="/single-product">Product Details</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--================End Home Banner Area =================-->

   <!--================Single Product Area =================-->
   <div class="product_image_area">
    <div class="container">
        <div class="row s_product_inner">
            <div class="col-lg-6">
            <div class="s_product_img">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            @if(count($imageUrls) > 0)
                @for($i = 1; $i <= 5; $i++)
                    @if(!empty($product->{'image'.$i.'_url'}))
                        <li data-target="#carouselExampleIndicators" data-slide-to="{{ $i - 1 }}" class="{{ $i == 1 ? 'active' : '' }}">
                            <img src="{{ asset($product->{'image'.$i.'_url'}) }}" alt="{{ $product->product_name }}" style="max-width: 60px; height: auto; cursor: pointer; border: 2px solid transparent;">
                        </li>
                    @endif
                @endfor
            @endif
        </ol>

        <div class="carousel-inner">
            @if(count($imageUrls) > 0)
                @for($i = 1; $i <= 5; $i++)
                    @if(!empty($product->{'image'.$i.'_url'}))
                        <div class="carousel-item {{ $i == 1 ? 'active' : '' }}">
                            <img class="d-block w-100" src="{{ asset($product->{'image'.$i.'_url'}) }}" alt="{{ $product->product_name }}" style="max-height: 400px; object-fit: contain;">
                        </div>
                    @endif
                @endfor
            @endif
        </div>
    </div>
</div>
</div>
     

<div class="col-lg-6">
    <div class="s_product_text float-right">
        <h3>{{ $product->product_name }}</h3>
        @if ($product->discount && isset($product->discounted_price))
            <span>Discount {{ $product->discount_category_name }}</span><br>
            <span class="badge badge-success">{{ $product->discount->percentage }}% Off</span>
            <del>Rp {{ number_format($product->price, 0, ',', '.') }}</del><br>

            <h2>Rp {{ number_format($product->discounted_price, 0, ',', '.') }}</h2>

        @else
        <h2>Rp {{ number_format($product->price, 0, ',', '.') }}</h2>

        @endif
        <ul class="list" style="margin-top: 15px;">
            <li>
                Category : <span style="background-color: #28a745; border-radius: 5px; padding: 5px;">
                    <a href="{{ route('category.index', ['category_id' => $product->category->id]) }}" style="color: white; font-weight: bold;  border-radius: 5px; padding: 5px; transition: background-color 0.3s;">
                        {{ $product->category->category_name }}
                    </a>
                </span>
            </li>
            <li>    
                <span>Availability</span> : {{ $product->stok_quantity > 0 ? 'In Stock' : 'Out of Stock' }}
            </li>
            @if ($product->stok_quantity > 0)
                <li>
                    <span>Remaining Stock</span> : {{ $product->stok_quantity }}
                </li>
            @endif
        </ul>

        <form id="wishlist-form" action="{{ route('wishlist-product.add') }}" method="post" style="display: inline;">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1" id="quantity_input">
            <input type="hidden" name="selected_image" id="selected_image" value="1">
        </form>

        <form id="add-to-cart-form" action="{{ route('add-to-cart') }}" method="POST" style="display: inline;">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="price" value="{{ $product->discounted_price ?: $product->price }}">
            <input type="hidden" name="hasDiscount" value="{{ $product->discounted_price ? '1' : '0' }}">
            <input type="hidden" name="selected_image" id="selected_image" value="1">
        </form>

        <div class="card_area" style="display: flex; align-items: center; margin-top: 15px;">
            <a class="main_btn" href="#" onclick="event.preventDefault(); document.getElementById('add-to-cart-form').submit();">Add to Cart</a>
            <a class="icon_btn" href="#" onclick="event.preventDefault(); document.getElementById('wishlist-form').submit();" style="margin-left: 10px;">
                <i class="lnr lnr-heart" style="font-size: 24px; color: red;"></i>
            </a>
        </div>
    </div>
</div>


<script>
    // Script to handle the form submission via the link click
    document.querySelector('.icon_btn').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default link behavior
        document.getElementById('wishlist-form').submit(); // Submit the form
    });

    document.querySelector('.main_btn').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default link behavior
        document.getElementById('add-to-cart-form').submit(); // Submit the form
    });

</script>


    </div>
</div>


        </div>
    </div>
</div>

    <!--================End Single Product Area =================-->

    <!--================Product Description Area =================-->
    <section class="product_description_area">
    <div class="container">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link " id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                    aria-selected="true">Description</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="review-tab" data-toggle="tab" href="#review" role="tab"
                    aria-controls="review" aria-selected="false">Reviews</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade " id="home" role="tabpanel" aria-labelledby="home-tab">
                <p>{{ $product->description }}</p>
            </div>
            <div class="tab-pane fade show active" id="review" role="tabpanel" aria-labelledby="review-tab">
    <div class="row">
        <div class="col-lg-6">
            <h3>Product Review</h3>
            <hr>
            <div class="review_list">
                @if($product->reviews->isNotEmpty())
                    @foreach($product->reviews as $review)
                        <div class="review_item">
                            <div class="media">
                                <div class="media-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>
                                            <h4 class="review_name" style="font-size: 18px; font-family: 'Arial', sans-serif;">{{ $review->customer->name }}</h4>
                                        </span>
                                        <span>
                                        <h4 class="review_rating" style="font-style: italic; font-family: 'Arial', sans-serif;">
                                            Rating:
                                            @for ($i = 0; $i < 5; $i++)
                                                @if ($i < $review->rating)
                                                    <i class="fa fa-star"></i>
                                                @else
                                                    <i class="fa fa-star-o" style="color: rgba(0,0,0,0.2)"></i>
                                                @endif
                                            @endfor
                                        </h4>
                                        </span>
                                    </div>
                                    <p>{{ $review->comment }}</p>
                                </div>
                            </div>
                            @if(Auth::check() && Auth::id() == $review->customer_id)
    <form id="delete-review-form-{{ $review->id }}" action="{{ route('delete_review', ['id' => $review->id]) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-danger btn-sm float-right delete-review-button" data-review-id="{{ $review->id }}">
            <i class="fa-solid fa-trash"></i>
        </button>
    </form>
@endif

                        </div>
                        <hr>
                    @endforeach
                @else
                    <p>No reviews available.</p>
                @endif
            </div>
        </div>
 



<div class="col-lg-6">
    <div class="review_box">
        <h4>Add a Review</h4>
        <form class="contact_form" action="{{ route('submit_review', ['id' => $product->id]) }}" method="POST">
    @csrf
    <div class="form-group d-flex align-items-center">
        <label for="rating" class="mr-2">Your Rating:</label>
        <input type="hidden" name="rating" id="rating" value="0"> <!-- Input tersembunyi untuk menyimpan rating -->
        <div id="star-rating" class="star-rating">
            <i class="fa fa-star" data-rating="1"></i>
            <i class="fa fa-star" data-rating="2"></i>
            <i class="fa fa-star" data-rating="3"></i>
            <i class="fa fa-star" data-rating="4"></i>
            <i class="fa fa-star" data-rating="5"></i>
        </div>
    </div>

    <div class="form-group">
        <label for="comment">Your Review:</label>
        <textarea name="comment" id="comment" cols="30" rows="5" class="form-control" placeholder="Your review"></textarea>
    </div>
    <div class="text-right">
        <button type="submit" class="btn submit_btn">Submit Now</button>
    </div>
</form>

<!-- Load Font Awesome library -->
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

<!-- Script to handle star rating -->
<script>
    // Select all star icons
    const starIcons = document.querySelectorAll('.star-rating i');

    // Add event listener to each star icon
    starIcons.forEach(icon => {
        icon.addEventListener('click', function() {
            // Set the rating value to the clicked star's data-rating attribute
            const rating = parseInt(this.getAttribute('data-rating'));
            document.getElementById('rating').value = rating;

            // Remove 'checked' class from all stars
            starIcons.forEach(icon => {
                icon.classList.remove('checked');
            });

            // Add 'checked' class to stars up to the clicked star
            for (let i = 0; i < rating; i++) {
                starIcons[i].classList.add('checked');
            }
        });
    });
</script>

<!-- Style for star icons -->
<style>
    .star-rating {
        cursor: pointer;
    }

    .star-rating i {
        color: #ddd;
        transition: color 0.2s;
    }

    .star-rating i.checked {
        color: #f39c12; /* Warna bintang yang dipilih */
    }
</style>


    </div>
</div>




                </div>
            </div>
        </div>
    </div>
</section>

    <!--================End Product Description Area =================-->

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


<!-- Load SweetAlert library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Script to handle delete review confirmation -->
<script>
    // Find all delete review buttons
    const deleteReviewButtons = document.querySelectorAll('.delete-review-button');

    // Add event listener to each delete review button
    deleteReviewButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Get the review ID
            const reviewId = this.getAttribute('data-review-id');

            // Show confirmation popup
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this review!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form for review deletion
                    document.getElementById('delete-review-form-' + reviewId).submit();
                }
            });
        });
    });
</script>

<script>
    document.querySelectorAll('.carousel-indicators li').forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            document.getElementById('selected_image').value = index + 1;
        });
    });
</script>

@endsection