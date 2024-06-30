<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Register</title>
    <meta name="author" content="Untree.co">
    <link rel="shortcut icon" href="favicon.png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="loginregisterstyle.css">

    <style>
        /* CSS untuk tombol "Create an account" yang dinonaktifkan */
        #createAccountBtn:disabled {
            background-color: #e9ecef; /* Ubah warna latar belakang menjadi abu-abu */
            border-color: #e9ecef; /* Ubah warna border menjadi abu-abu */
            cursor: not-allowed; /* Ubah kursor menjadi tanda silang saat tombol dinonaktifkan */
        }
    </style>
</head>
<body>

<div class="site-wrap d-md-flex align-items-stretch">
    <form class="register-form" method="POST" action="{{ route('register') }}">
        @csrf
        <div class="bg-img" style="background-image: url('images/cloth2.jpg')"></div>
        <div class="form-wrap">
            <div class="form-inner">
                <h1 class="title">Register</h1>
                <p class="caption mb-4">Create your account in seconds.</p>

                <!-- Full Name -->
                <div class="form-floating">
                    <input id="name" type="text" name="name" placeholder="Full Name" value="{{ old('name') }}" required autocomplete="name" autofocus class="form-control @error('name') is-invalid @enderror">
                    <label for="name">Full Name</label>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-floating">
                    <input id="email" type="email" name="email" placeholder="info@example.com" value="{{ old('email') }}" required autocomplete="email" class="form-control @error('email') is-invalid @enderror">
                    <label for="email">Email</label>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    @if ($errors->has('email') && !old('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>Email is required.</strong>
                        </span>
                    @endif
                </div>

                <!-- Password -->
                <div class="form-floating">
                    <span class="password-show-toggle js-password-show-toggle" onclick="togglePasswordVisibility('password')"><span class="uil"></span></span>
                    <input id="password" type="password" name="password" placeholder="Password" required autocomplete="new-password" class="form-control @error('password') is-invalid @enderror">
                    <label for="password">Password</label>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-floating">
                    <span class="password-show-toggle js-password-show-toggle" onclick="togglePasswordVisibility('password-confirm')"><span class="uil"></span></span>
                    <input id="password-confirm" type="password" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password" class="form-control">
                    <label for="password-confirm">Confirm Password</label>
                </div>

                <!-- Checkbox untuk persetujuan ketentuan layanan -->
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="agreeCheckbox" onchange="toggleCreateButton()">
                    <label for="agreeCheckbox" class="form-check-label">I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></label>
                </div>

                <!-- Tombol Create an account -->
                <div class="d-grid mb-4">
                    <button type="submit" id="createAccountBtn" class="btn btn-primary" disabled>Create an account</button>
                </div>

                <div class="mb-2">Already a member? <a href="{{ route('login') }}">Login</a></div>

                
            </div>
        </div>
    </form>
</div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="js/custom2.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>

    <script>
    // Fungsi untuk menampilkan atau menyembunyikan password saat ikon mata diklik
    function togglePasswordVisibility(inputId) {
        var inputField = document.getElementById(inputId);
        var icon = document.querySelector('#' + inputId + ' + .password-show-toggle .uil');

        // Toggle visibility of password
        if (inputField.type === "password") {
            inputField.type = "text";
            icon.classList.remove('uil-eye');
            icon.classList.add('uil-eye-slash');
        } else {
            inputField.type = "password";
            icon.classList.remove('uil-eye-slash');
            icon.classList.add('uil-eye');
        }
    }
</script>

<script>
    // Fungsi untuk mengaktifkan atau menonaktifkan tombol "Create an account" berdasarkan status checkbox
    function toggleCreateButton() {
        var agreeCheckbox = document.getElementById('agreeCheckbox');
        var createAccountBtn = document.getElementById('createAccountBtn');

        // Jika checkbox dicentang, aktifkan tombol "Create an account"
        if (agreeCheckbox.checked) {
            createAccountBtn.disabled = false;
        } else {
            // Jika checkbox tidak dicentang, nonaktifkan tombol "Create an account"
            createAccountBtn.disabled = true;
        }
    }
</script>

</body>
</html>
