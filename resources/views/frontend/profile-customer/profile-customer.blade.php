@extends('frontend.landingpage.main')
@section('title', 'Product Detail Page')
@section('page', 'Product Detail Page')
@section('header')
    @include('frontend.landingpage.header')


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <style>
        body {
            margin-top: 20px;
            background-color: #f2f6fc;
            color: #69707a;
            font-family: Arial, sans-serif;
        }

        .img-account-profile {
            height: 10rem;
        }

        .rounded-circle {
            border-radius: 50% !important;
        }

        .card {
            box-shadow: 0 0.15rem 1.75rem 0 rgb(33 40 50 / 15%);
        }

        .card-header {
            font-weight: 500;
            background-color: rgba(33, 40, 50, 0.03);
            border-bottom: 1px solid rgba(33, 40, 50, 0.125);
        }

        .form-control {
            font-size: 0.875rem;
            border-radius: 0.35rem;
        }

        .nav-borders .nav-link.active {
            color: #0061f2;
            border-bottom-color: #0061f2;
        }

        .nav-borders .nav-link {
            color: #69707a;
            border-bottom-width: 0.125rem;
            border-bottom-style: solid;
            border-bottom-color: transparent;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
            padding-left: 0;
            padding-right: 0;
            margin-left: 1rem;
            margin-right: 1rem;
        }

        a {
  text-decoration: none;
}

    </style>
</head>

<body>

    <div class="container-xl px-4 mt-4">
        <!-- Account page navigation-->
        <nav class="nav nav-borders">
            <a class="nav-link active ms-0" href="#">User Profile</a>
        </nav>
        <hr class="mt-0 mb-4">
        <div class="row">
            <div class="col-xl-4">

            @if ($errors->has('profile_picture'))
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ $errors->first('profile_picture') }}'
        });
    </script>
@endif
                <!-- Profile picture form -->
<form action="{{ route('profile.picture.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <!-- Profile picture card-->
    <div class="card mb-4 mb-xl-0">
        <div class="card-header">Profile Picture</div>
        <div class="card-body text-center">
            <!-- Profile picture image-->
            <img class="img-account-profile rounded-circle mb-2" src="{{ $customer->profile_picture_url }}" alt="Profile Picture">
            <!-- Profile picture help block-->
            <div class="small font-italic text-muted mb-4">Image no larger than 5 MB</div>
            <!-- Profile picture upload button-->
            <input class="form-control" type="file" name="profile_picture" id="profile_picture">
        </div>
    </div>
    <!-- Submit button -->
    <button type="submit" class="btn btn-primary mt-3">Update Profile Picture</button>
</form>


            </div>
            <div class="col-xl-8">
                <!-- Account details card-->
                <div class="card mb-4">
                    <div class="card-header">Account Details</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('customer.update-profile') }}" enctype="multipart/form-data">
                            @csrf
                            <!-- Form Group (username)-->
                            <div class="mb-3">
                                <label class="small mb-1" for="inputUsername">Username (how your name will appear to other users on the site)</label>
                                <input class="form-control" id="inputUsername" type="text" placeholder="Enter your username" name="name" value="{{ $customer->name }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputFirstName">Home Address</label>
                                    <input class="form-control" id="inputFirstName" type="text" placeholder="Enter your First Address" name="address1" value="{{ $customer->address1 }}">
                                    @error('address1')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                <label class="small mb-1" for="inputLastName">City</label>
                                <select class="form-select" id="inputCity" name="address2">
                                    <option value="">Select City</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city['city_name'] }}" @if($city['city_name'] == $customer->address2) selected @endif>{{ $city['city_name'] }}</option>
                                    @endforeach
                                </select>
                                @error('address2')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="small mb-1" for="inputOrgName">Province</label>
                                <select class="form-select" id="inputProvince" name="address3">
                                    <option value="">Select Province</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province['province'] }}" @if($province['province'] == $customer->address3) selected @endif>{{ $province['province'] }}</option>
                                    @endforeach
                                </select>
                                @error('address3')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            </div>
                            <!-- Form Group (email address)-->
                            <div class="mb-3">
                                <label class="small mb-1" for="email">Email address</label>
                                <input class="form-control" id="email" type="email" placeholder="Enter your email address" name="email" value="{{ $customer->email }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="phone">Phone number</label>
                                    <input class="form-control" id="phone" type="tel" placeholder="Enter your phone number" name="phone" value="{{ $customer->phone }}">
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="password">Password</label>
                                    <input class="form-control" id="password" type="password" name="password" placeholder="Change your password">
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- Save changes button-->
                            <button class="btn btn-primary" type="submit">Save changes</button>
                            <a href="/cart"><button class="btn btn-danger" type="button">Cancel</button></a>
                        </form>
                        


                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    @if(session('success'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                title: 'Success!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
</body>
</html>
@endsection