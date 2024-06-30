<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login</title>
    <meta name="author" content="Untree.co">
    <link rel="shortcut icon" href="../favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="../loginregisterstyle.css">

    <style>
        #loginBtn:disabled {
            background-color: #e9ecef; 
            border-color: #e9ecef; 
            cursor: not-allowed; 
        }
    </style>
</head>
<body>


    <div class="site-wrap d-md-flex align-items-stretch">
        <form class="login-form" method="POST" action="{{ route('customer.login') }}">
            @csrf
            <div class="bg-img" style="background-image: url('../images/z.jpg')"></div>
            <div class="form-wrap">
                <div class="form-inner">
                    <h1 class="title">Customer Login</h1>
                    <p class="caption mb-4">Please enter your login details to sign in.</p>

                    <div class="form-floating">
                        <input type="text" class="form-control" id="login" name="login" placeholder="Email or Full Name" value="{{ old('login') }}" required autocomplete="login" autofocus>
                        <label for="login">Email or Full Name</label>
                        @error('login')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-floating">
                        <span class="password-show-toggle js-password-show-toggle"><span class="uil"></span></span>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required autocomplete="current-password">
                        <label for="password">Password</label>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <div class="form-check">
                        </div>
                        <div><a href="{{ route('password.request') }}">Forgot password?</a></div>
                    </div>
    
                    <div class="d-grid mb-4">
                        <button type="submit" id="loginBtn" class="btn btn-primary" disabled>Log in</button>
                    </div>

                    <div class="mb-2">Don't have an account? <a href="{{ route('customer.register') }}">Register</a></div>
                    <!-- <div class="mb-2">Want to become a seller? <a href="{{ route('register') }}">Register as a seller</a></div> -->
             
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="../js/custom2.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>

    <script>
    function checkLoginForm() {
        var loginInput = document.getElementById('login').value.trim();
        var passwordInput = document.getElementById('password').value.trim();
        var loginBtn = document.getElementById('loginBtn');

        if (loginInput !== '' && passwordInput !== '') {
            loginBtn.disabled = false;
        } else {
            loginBtn.disabled = true;
        }
    }

    document.getElementById('login').addEventListener('input', checkLoginForm);
    document.getElementById('password').addEventListener('input', checkLoginForm);
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let successMessage = '{{ session('success') }}';

    if (successMessage) {
        Swal.fire({
            icon: 'success',
            title: 'Registration Successful!',
            text: successMessage,
            showConfirmButton: false,
            timer: 1500
        });
    }
</script>
</body>
</html>


