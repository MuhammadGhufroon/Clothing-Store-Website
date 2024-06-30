@extends('admin.dashboard.main')
@section('title', 'Create Vendor')
@section('sidenav')
    @include('admin.dashboard.sidenav')
@endsection
@section('page', 'Create Vendor')
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

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('vendor.store') }}" method="POST" id="createVendorForm">
                        @csrf
                        <div class="mb-3 ms-3 me-3">
                            <label for="name" class="form-label">Name</label>
                            <div class="border-contrast p-1 rounded">
                                <input type="text" class="form-control border-0" id="name" name="name" required>
                            </div>
                            @error('name')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 ms-3 me-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="border-contrast p-1 rounded">
                                <input type="email" class="form-control border-0" id="email" name="email" required>
                            </div>
                            @error('email')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 ms-3 me-3">
                            <label for="phone" class="form-label">Phone</label>
                            <div class="border-contrast p-1 rounded">
                                <input type="text" class="form-control border-0" id="phone" name="phone" required>
                            </div>
                            @error('phone')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 ms-3 me-3">
                            <label for="address" class="form-label">Address</label>
                            <div class="border-contrast p-1 rounded">
                                <input type="text" class="form-control border-0" id="address" name="address" required>
                            </div>
                            @error('address')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row ms-3 me-3 justify-content-end">
                            <div class="col-3">
                                <a href="{{ route('vendor.index') }}" class="btn btn-secondary w-100">Cancel</a>
                            </div>
                            <div class="col-3">
                                <button type="button" id="save" class="btn btn-primary w-100">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="footer pt-5">
    <div class="container-fluid">
        <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
                <div class="copyright text-center text-sm text-muted text-lg-start">
                    © <script>
                        document.write(new Date().getFullYear())
                    </script>, made with <i class="fa fa-heart"></i> by
                    <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Orang Ganteng</a> for a better web.
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

<!-- Include SweetAlert script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
document.getElementById("save").addEventListener("click", function() {
    let name = document.getElementById("name").value;
    let email = document.getElementById("email").value;
    let phone = document.getElementById("phone").value;
    let address = document.getElementById("address").value;

    let errorMessages = [];

    if (name.trim() === "") {
        errorMessages.push("Name is required");
    }
    if (email.trim() === "") {
        errorMessages.push("Email is required");
    }
    if (phone.trim() === "") {
        errorMessages.push("Phone is required");
    }
    if (address.trim() === "") {
        errorMessages.push("Address is required");
    }

    if (errorMessages.length > 0) {
        Swal.fire({
            icon: 'error',
            title: 'Validation Error!',
            html: errorMessages.join('<br>'),
        });
    } else {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to create this vendor?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, create it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("createVendorForm").submit();
            }
        });
    }
});
</script>
@endsection
