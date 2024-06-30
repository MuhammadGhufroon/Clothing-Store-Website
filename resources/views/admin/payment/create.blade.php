@extends('admin.dashboard.main')
@section('title', 'Create Payment')
@section('sidenav')
    @include('admin.dashboard.sidenav')
@endsection
@section('page', 'Create Payment')
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
    <form action="{{ route('payment.store') }}" method="post" id="PaymentForm" enctype="multipart/form-data">
        @csrf
        <div class="mb-3 ms-3 me-3">
            <label for="order_id" class="form-label">Order ID</label>
            <div class="border-contrast p-1 rounded"> 
                <select class="form-select border-0" id="order_id" name="order_id" aria-label="Order ID">
                    <!-- Loop through available orders -->
                    @foreach($orders as $order)
                        <option value="{{ $order->id }}">{{ $order->id }}</option>
                    @endforeach
                </select>
            </div>
            @error('order_id')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 ms-3 me-3">
            <label for="payment_date" class="form-label">Payment Date</label>
            <div class="border-contrast p-1 rounded"> 
                <input type="datetime-local" class="form-control border-0" id="payment_date" name="payment_date" placeholder="Payment Date" aria-label="payment_date" value="{{ old('payment_date') }}">
            </div>
            @error('payment_date')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 ms-3 me-3">
            <label for="payment_method" class="form-label">Payment Method</label>
            <div class="border-contrast p-1 rounded"> 
                <input type="text" class="form-control border-0" id="payment_method" name="payment_method" placeholder="Payment Method" aria-label="payment_method" value="{{ old('payment_method') }}">
            </div>
            @error('payment_method')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 ms-3 me-3">
            <label for="amount" class="form-label">Amount</label>
            <div class="border-contrast p-1 rounded"> 
                <input type="number" class="form-control border-0" id="amount" name="amount" placeholder="Amount" aria-label="amount" value="{{ old('amount') }}">
            </div>
            @error('amount')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <div class="row ms-3 me-3 justify-content-end">
            <div class="col-3">
                <a href="{{ route('payment.index') }}" class="btn bg-gradient-secondary w-100">Cancel</a>
            </div>
            <div class="col-3">
                <button type="button" id="save" class="btn bg-gradient-primary w-100">Create</button>
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
    const form = document.getElementById("PaymentForm");

    function simpan() {
        let order_id = document.getElementById("order_id").value;
        let payment_date = document.getElementById("payment_date").value;
        let payment_method = document.getElementById("payment_method").value;
        let amount = document.getElementById("amount").value;

        // Membuat array untuk menyimpan pesan kesalahan
        let errorMessages = [];

        // Memeriksa input dan menambahkan pesan kesalahan ke array jika diperlukan
        if (order_id.trim() === "") {
            errorMessages.push("Order ID is required");
        }

        if (payment_date.trim() === "") {
            errorMessages.push("Payment Date is required");
        }

        if (payment_method.trim() === "") {
            errorMessages.push("Payment Method is required");
        }

        if (amount.trim() === "") {
            errorMessages.push("Amount is required");
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
                text: 'Do you want to create this payment?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, create it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika pengguna mengklik 'Yes', submit form untuk membuat pembayaran
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

