@extends('admin.dashboard.main')
@section('title', 'Purchase Create')
@section('sidenav')
    @include('admin.dashboard.sidenav')
@endsection
@section('page', 'Purchase Create')
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
            <form action="{{ route('vendor.purchase') }}" method="POST" id="PurchaseForm">
                @csrf

                @if(session('success'))
                    <div class="alert alert-success ms-3 me-3 mt-3">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mb-3 ms-3 me-3">
                    <label for="product" class="form-label">Product</label>
                    <div class="border-contrast p-1 rounded">
                        <select name="product_id" id="product" class="form-select border-0" aria-label="product_id">
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('product_id')
                        <div class="error-message ms-3">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 ms-3 me-3">
                    <label for="vendor" class="form-label">Vendor</label>
                    <div class="border-contrast p-1 rounded">
                        <select name="vendor_id" id="vendor" class="form-select border-0" aria-label="vendor_id">
                            @foreach($vendors as $vendor)
                                <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('vendor_id')
                        <div class="error-message ms-3">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 ms-3 me-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <div class="border-contrast p-1 rounded"> 
                        <input type="number" class="form-control border-0" id="quantity" name="quantity" min="1" required>
                    </div>
                    @error('quantity')
                        <div class="error-message ms-3">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row ms-3 me-3 justify-content-end">
                    <div class="col-3">
                        <a href="{{ route('vendor.purchase.index') }}" class="btn bg-gradient-secondary w-100">Cancel</a>
                    </div>
                    <div class="col-3">
                        <button type="submit" class="btn bg-gradient-primary w-100">Purchase</button>
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

    <!-- Include SweetAlert script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    document.getElementById("PurchaseForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Menghentikan pengiriman formulir

        let product_id = document.getElementById("product").value;
        let quantity = document.getElementById("quantity").value;

        // Membuat array untuk menyimpan pesan kesalahan
        let errorMessages = [];

        // Memeriksa setiap input dan menambahkan pesan kesalahan ke array jika diperlukan
        if (product_id.trim() === "") {
            errorMessages.push("Product is required");
        }
        if (quantity.trim() === "" || quantity <= 0) {
            errorMessages.push("Quantity must be a positive number");
        }

        // Menampilkan pesan kesalahan jika ada
        if (errorMessages.length > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error!',
                html: errorMessages.join('<br>'), // Menampilkan pesan kesalahan dalam format yang terbaca
            });
        } else {
            // Jika tidak ada pesan kesalahan, tampilkan pesan konfirmasi
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to make this purchase?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, purchase it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika pengguna mengklik 'Yes', submit form untuk membuat pembelian
                    document.getElementById("PurchaseForm").submit();
                }
            });
        }
    });
</script>
@endsection

