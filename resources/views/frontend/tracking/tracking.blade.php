@extends('frontend.landingpage.main')
@section('title', 'Order Costs Page')
@section('page', 'Order Costs Page')
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
              <h2>Check Order Costs</h2>
              <p>Please enter your data and Check Order of your purchase.</p>
            </div>
            <div class="page_link">
              <a href="/">Home</a>
              <a href="/tracking">Check Order Costs</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--================End Home Banner Area =================-->

 <!--================Tracking Box Area =================-->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<section class="tracking_box_area section_gap">
    <div class="container">
        <div class="tracking_box_inner">
            <p>To Check your order please enter any data in the box below and press the "Check Cost" button.</p>
            <form class="row tracking_form" action="" method="post" novalidate="novalidate">
                @csrf
                <div class="col-md-6 form-group">
                    <label for="origin">Origin City</label>
                    <select class="form-control" id="origin" name="origin" required>
                        <option value="">Select Origin City</option>
                        @foreach ($cities as $city)
                            <option value="{{$city['city_id']}}">{{$city['city_name']}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 form-group">
                    <label for="destination">Destination City</label>
                    <select class="form-control" id="destination" name="destination" required>
                        <option value="">Select Destination City</option>
                        @foreach ($cities as $city)
                            <option value="{{$city['city_id']}}">{{$city['city_name']}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 form-group">
                    <label for="weight">Weight (g)</label>
                    <input type="text" class="form-control" id="weight" name="weight" placeholder="Weight (g)" required>
                </div>
                <div class="col-md-6 form-group">
                    <label for="courier">Courier</label>
                    <select class="form-control" id="courier" name="courier" required>
                        <option value="">Select Courier</option>
                        <option value="jne">JNE</option>
                        <option value="pos">Pos Indonesia</option>
                        <option value="tiki">Tiki</option>
                        <!-- Add more courier options here if needed -->
                    </select>
                </div>
                
                <div class="col-md-12 form-group">
                    <button type="submit" name="cekOngkir" value="submit" class="btn-success submit_btn custom-btn">
                        Check Cost
                    </button>
                </div>
            </form>
            <div class="mt-5">
                @if ($error)
                    <div class="alert alert-danger">{{ $error }}</div>
                @endif
                @if ($ongkir != '')
                    <h3>Shipping Details</h3>
                    <h4>
                        <ul>
                            <li>Origin City: {{ $ongkir['origin_details']['city_name'] }}</li>
                            <li>Destination City: {{ $ongkir['destination_details']['city_name'] }}</li>
                            <li>Package Weight: {{ $ongkir['query']['weight'] }} grams</li>
                        </ul>
                    </h4>
                    @foreach ($ongkir['results'] as $item)
                        <div>
                            <label for="name">Name: {{$item['name']}}</label>
                            @foreach ($item['costs'] as $cost)
                                <div class="mb-3">
                                    <label for="service">Service: {{$cost['service']}}</label>
                                    @foreach ($cost['cost'] as $harga)
                                        <div class="mb-3">
                                            <label for="harga">
                                                Harga : {{$harga['value']}} (est : {{ $harga['etd'] }} hari)
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<!--================End Tracking Box Area =================-->



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

@endsection