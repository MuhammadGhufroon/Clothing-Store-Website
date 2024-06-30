@extends('admin.dashboard.main')
@section('title', 'Edit Customer')
@section('sidenav')
    @include('admin.dashboard.sidenav')
@endsection
@section('page', 'Edit Customer')
@section('nav')
    @include('admin.dashboard.nav')

    <style>
        .border-contrast {
            transition: border-color 0.3s ease; 
            border: 1px solid #ced4da; 
            width: 100%; 
        }

        .border-contrast:focus-within {
            border-color: #ff69b4; 
        }

        .form-label {
            font-weight: bold;
            margin-top: 20px;
        }

        .card {
            margin-top: 30px;
            margin-left: 150px;
            width: 70%;
        }
        
        .col-3 {
            margin-top: 30px;
        }

        .error-message {
            color: red;
            font-size: 12px;
        }
    </style>

    <div class="card mb-4">
        <div class="card-border-1 ms-3 me-3">
            <form action="{{ route('customer.update', $customer->id) }}" method="post" id="CustomerFormEdit" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3 ms-3 me-3">
                    <label for="name" class="form-label">Name</label>
                    <div class="border-contrast p-1 rounded"> 
                        <input type="text" class="form-control border-0" id="name" name="name" placeholder=" Name" aria-label="name" value="{{ $customer->name }}">
                    </div>
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 ms-3 me-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="border-contrast p-1 rounded"> 
                        <input type="email" class="form-control border-0" id="email" name="email" placeholder=" Email" aria-label="email" value="{{ $customer->email }}">
                    </div>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 ms-3 me-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="border-contrast p-1 rounded"> 
                        <input type="password" class="form-control border-0" id="password" name="password" placeholder=" Password" aria-label="password" value="{{ $customer->password }}">
                    </div>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 ms-3 me-3">
                    <label for="phone" class="form-label">Phone</label>
                    <div class="border-contrast p-1 rounded"> 
                        <input type="text" class="form-control border-0" id="phone" name="phone" placeholder=" Phone" aria-label="phone" value="{{ $customer->phone }}">
                    </div>
                    @error('phone')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 ms-3 me-3">
                    <label for="address1" class="form-label">Address Line 1</label>
                    <div class="border-contrast p-1 rounded"> 
                        <input type="text" class="form-control border-0" id="address1" name="address1" placeholder=" Address Line 1" aria-label="address1" value="{{ $customer->address1 }}">
                    </div>
                    @error('address1')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 ms-3 me-3">
                    <label for="address2" class="form-label">Address Line 2</label>
                    <div class="border-contrast p-1 rounded"> 
                        <input type="text" class="form-control border-0" id="address2" name="address2" placeholder=" Address Line 2" aria-label="address2" value="{{ $customer->address2 }}">
                    </div>
                    @error('address2')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 ms-3 me-3">
                    <label for="address3" class="form-label">Address Line 3</label>
                    <div class="border-contrast p-1 rounded"> 
                        <input type="text" class="form-control border-0" id="address3" name="address3" placeholder=" Address Line 3" aria-label="address3" value="{{ $customer->address3 }}">
                    </div>
                    @error('address3')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row ms-3 me-3 justify-content-end">
                    <div class="col-3">
                        <a href="{{ route('customer.index') }}" class="btn bg-gradient-secondary w-100">Cancel</a>
                    </div>
                    <div class="col-3">
                        <button type="button" id="save" class="btn bg-gradient-primary w-100">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <footer class="footer pt-5">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-lg-between">
                <div class="col-lg-6 mb-lg-0 mb-4">
                    <div class="copyright text-center text-sm text-muted text-lg-start">
                        © <script>
                            document.write(new Date().getFullYear())
                        </script>,
                        made with <i class="fa fa-heart"></i> by
                        <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Orang Ganteng</a>
                        for a better web.
                    </div>
                </div>
                <div class="col-lg-6">
                    <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                        <li class="nav-item">
                            <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Creative Tim</a>
                        </li>
                        <li class="nav-item">
                            <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted" target="_blank">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a href="https://www.creative-tim.com/blog" class="nav-link text-muted" target="_blank">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted" target="_blank">License</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>


<script>
    const btnSave = document.getElementById("save");
    const form = document.getElementById("CustomerFormEdit");

    function simpan() {
        let name = document.getElementById("name").value;
        let email = document.getElementById("email").value;
        let password = document.getElementById("password").value;
        let phone = document.getElementById("phone").value;
        let address1 = document.getElementById("address1").value;
        let address2 = document.getElementById("address2").value;
        let address3 = document.getElementById("address3").value;

        // Membuat array untuk menyimpan pesan kesalahan
        let errorMessages = [];

        // Memeriksa input dan menambahkan pesan kesalahan ke array jika diperlukan
        if (name.trim() === "") {
            errorMessages.push("Name is required");
        }

        if (email.trim() === "") {
            errorMessages.push("Email is required");
        }

        if (password.trim() === "") {
            errorMessages.push("Password is required");
        }

        if (
            address1.trim() === "" && 
            address2.trim() === "" && 
            address3.trim() === ""  
            ) {
            errorMessages.push("At least one address is required");
        }

        // Menampilkan pesan kesalahan jika ada
        if (errorMessages.length > 0) {
            // Jika terdapat pesan kesalahan, tampilkan dalam SweetAlert2
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                html: errorMessages.join('<br>'), // Menampilkan pesan kesalahan dalam format yang terbaca
            });
        } else {
            // Jika tidak ada pesan kesalahan, tampilkan pesan konfirmasi
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to update this customer?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika pengguna mengklik 'Yes', submit form untuk mengupdate data pelanggan
                    form.submit();
                }
            });
        }
    }

    btnSave.onclick = function () {
        simpan();
    };
</script>
@endsection

