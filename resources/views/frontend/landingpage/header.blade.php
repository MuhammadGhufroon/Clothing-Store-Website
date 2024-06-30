<!--================Header Menu Area =================-->
<header class="header_area">
    <div class="top_menu">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="float-left">
                        <p>Phone: +62 8123 1588 180</p>
                        <p>Email: clothingstore@gmail.com</p>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="float-right">
                        <ul class="right_side">
                            <li>
                                <a href="/delivery-product">
                                    Track Order
                                </a>
                            </li>
                            <li>
                                <a href="/contact">
                                    Contact Us
                                </a>
                            </li>
                            <li>
                                <a href="/customer/login">
                                    Login/Register
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .img-logo {
            width: 130px; /* ganti dengan ukuran yang Anda inginkan */
            height: auto; /* agar rasio aspek gambar tetap terjaga */
        }
        .profile-image {
            width: 40px; /* ukuran gambar profil */
            height: 30px;
            border-radius: 50%;
            object-fit: cover;
            margin-left: 5px; /* spasi antara ikon pengguna dan gambar profil */
        }
        .profile-dropdown {
            position: relative;
        }
        .profile-dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            z-index: 1000;
            min-width: 180px;
            padding: 10px 0; /* Mengubah padding pada sisi atas dan bawah saja */
        }
        .profile-dropdown-menu a {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            color: #333;
            text-decoration: none;
        }
        .profile-dropdown-menu a:hover,
        .profile-dropdown-menu a:focus,
        .profile-dropdown-menu a:active {
            background-color: #71cd14;
            color: #fff;
            border-radius: 0 0 5px 5px; /* Apply the border-radius to the active item */
        }
        .profile-dropdown-menu i {
            margin-right: 10px;
        }
        .profile-dropdown:hover .profile-dropdown-menu {
            display: block;
        }
    </style>

    <div class="main_menu">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light w-100">
                <!-- Brand and toggle get grouped for better mobile display -->
                <a class="navbar-brand logo_h" href="/">
                    <img src="../img/new-icon.png" alt="" class="img-logo"/>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse offset w-100" id="navbarSupportedContent">
                    <div class="row w-100 mr-0">
                        <div class="col-lg-10 pr-0 offset-lg-2">
                            <ul class="nav navbar-nav center_nav pull-right">
                                <li class="nav-item {{ request()->is('home') ? 'active' : '' }}">
                                    <a class="nav-link" href="/home">Home</a>
                                </li>
                                <li class="nav-item submenu dropdown {{ request()->is('category*', 'single-product*', 'checkout*', 'cart*') ? 'active' : '' }}">
                                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">Shop</a>
                                    <ul class="dropdown-menu">
                                        <li class="nav-item">
                                            <a class="nav-link" href="/category">Product Category</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="/wishlist-product">Product Wishlist</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="/cart">Product Cart</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item submenu dropdown {{ request()->is('tracking*') ? 'active' : '' }}">
                                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">Pages</a>
                                    <ul class="dropdown-menu">
                                        <li class="nav-item">
                                            <a class="nav-link" href="/tracking">Order Costs</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="/delivery-product">Order Tracking</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item {{ request()->is('contact') ? 'active' : '' }}">
                                    <a class="nav-link" href="/contact">Contact</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 pr-0">
                    <ul class="nav navbar-nav navbar-right right_nav pull-right">
                        <li class="nav-item">
                            <a href="/cart" class="icons">
                                <i class="ti-shopping-cart"></i>
                                @if(isset($cartItemCount) && $cartItemCount > 0)
                                    <span class="badge badge-pill badge-success">{{ $cartItemCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item position-relative">
                            <a href="/wishlist-product" class="icons">
                                <i class="ti-heart" aria-hidden="true"></i>
                                @if($wishlistItemCount > 0)
                                    <span class="badge badge-pill badge-success">{{ $wishlistItemCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item profile-dropdown">
                            @auth
                                <a href="#" class="icons">                    
                                    @if (Auth::user()->roles !== 'admin' && Auth::user()->roles !== 'owner')
                                        {{ Auth::user()->name }}
                                    @else
                                        {{ Auth::user()->name }} - {{ Auth::user()->roles }}
                                    @endif
                                    @if (Auth::user()->profile_picture)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" class="profile-image" alt="Profile Picture">
                                    @else
                                        <img src="../img/icon-user.png" class="profile-image" alt="Default Profile Picture" style="width: 30px; height: 30px;"> <!-- Gambar default -->
                                    @endif
                                </a>
                                <ul class="profile-dropdown-menu">
                                    <li style="margin:0">
                                        <a href="/profile/customer">
                                            <i class="ti-user"></i> Profile
                                        </a>
                                    </li>
                                    <li style="margin:0">
                                        <a href="#" onclick="event.preventDefault(); logoutWithAlert();">
                                            <i class="ti-power-off"></i> Sign Out
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            @endauth
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>
<!--================Header Menu Area =================-->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function logoutWithAlert() {
        Swal.fire({
            icon: 'success',
            title: 'Logout Successful!',
            text: 'You have successfully logged out.',
            showConfirmButton: false,
            timer: 1500
        }).then(() => {
            document.getElementById('logout-form').submit();
        });
    }
</script>
