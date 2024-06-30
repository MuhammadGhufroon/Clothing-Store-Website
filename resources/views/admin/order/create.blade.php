@extends('admin.dashboard.main')
@section('title', 'Create Order')
@section('sidenav')
    @include('admin.dashboard.sidenav')
@endsection
@section('page', 'Create Order')
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
    <form action="{{ route('order.store') }}" method="post" id="OrderForm">
        @csrf
        <div class="mb-3 ms-3 me-3">
            <label for="customer_id" class="form-label">Customer</label>
            <div class="border-contrast p-1 rounded"> 
                <select class="form-select border-0" id="customer_id" name="customer_id">
                    <option value="">Select Customer</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endforeach
                </select>
            </div>
            @error('customer_id')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 ms-3 me-3">
            <label for="order_date" class="form-label">Order Date</label>
            <div class="border-contrast p-1 rounded"> 
                <input type="datetime-local" class="form-control border-0" id="order_date" name="order_date">
            </div>
            @error('order_date')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 ms-3 me-3">
            <label for="total_amount" class="form-label">Total Amount</label>
            <div class="border-contrast p-1 rounded"> 
                <input type="number" class="form-control border-0" id="total_amount" name="total_amount">
            </div>
            @error('total_amount')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 ms-3 me-3">
            <label for="status" class="form-label">Status</label>
            <div class="border-contrast p-1 rounded"> 
                <input type="text" class="form-control border-0" id="status" name="status">
            </div>
            @error('status')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <div class="row ms-3 me-3 justify-content-end">
            <div class="col-3">
                <a href="{{ route('order.index') }}" class="btn bg-gradient-secondary w-100">Cancel</a>
            </div>
            <div class="col-3">
                <button type="submit" id="save" class="btn bg-gradient-primary w-100">Create</button>
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
    const form = document.getElementById("OrderForm");

    function simpan() {
        let customer_id = document.getElementById("customer_id").value;
        let order_date = document.getElementById("order_date").value;
        let total_amount = document.getElementById("total_amount").value;
        let status = document.getElementById("status").value;

        let errorMessages = [];

        if (customer_id.trim() === "") {
            errorMessages.push("Customer is required");
        }

        if (order_date.trim() === "") {
            errorMessages.push("Order Date is required");
        }

        if (total_amount.trim() === "") {
            errorMessages.push("Total Amount is required");
        }

        if (status.trim() === "") {
            errorMessages.push("Status is required");
        }

        if (errorMessages.length > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                html: errorMessages.join('<br>') 
            });
        } else {
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to create this order?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, create it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    }

    btnSave.onclick = function (event) {
        event.preventDefault(); 
        simpan();
    };
</script>

@endsection

               
