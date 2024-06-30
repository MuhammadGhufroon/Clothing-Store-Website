@extends('admin.dashboard.main')
@section('title', 'Edit Delivery')
@section('sidenav')
    @include('admin.dashboard.sidenav')
@endsection
@section('page', 'Edit Delivery')
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
    <form action="{{ route('delivery.update', $delivery->id) }}" method="post" id="DeliveryForm" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3 ms-3 me-3">
            <label for="order_id" class="form-label">Order ID</label>
            <div class="border-contrast p-1 rounded"> 
                <select class="form-select border-0" id="order_id" name="order_id" aria-label="Order ID">
                    @foreach($orders as $order)
                        <option value="{{ $order->id }}" {{ $delivery->order_id == $order->id ? 'selected' : '' }}>{{ $order->id }}</option>
                    @endforeach
                </select>
            </div>
            @error('order_id')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 ms-3 me-3">
            <label for="shipping_date" class="form-label">Shipping Date</label>
            <div class="border-contrast p-1 rounded"> 
                <input type="datetime-local" class="form-control border-0" id="shipping_date" name="shipping_date" placeholder=" Shipping Date" aria-label="shipping_date" value="{{ old('shipping_date', $delivery->shipping_date) }}">
            </div>
            @error('shipping_date')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 ms-3 me-3">
            <label for="tracking_code" class="form-label">Tracking Code</label>
            <div class="border-contrast p-1 rounded"> 
                <input type="text" class="form-control border-0" id="tracking_code" name="tracking_code" placeholder=" Tracking Code" aria-label="tracking_code" value="{{ old('tracking_code', $delivery->tracking_code) }}">
            </div>
            @error('tracking_code')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 ms-3 me-3">
            <label for="status" class="form-label">Status</label>
            <div class="border-contrast p-1 rounded"> 
                <input type="text" class="form-control border-0" id="status" name="status" placeholder=" Status" aria-label="status" value="{{ old('status', $delivery->status) }}">
            </div>
            @error('status')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <div class="row ms-3 me-3 justify-content-end">
            <div class="col-3">
                <a href="{{ route('delivery.index') }}" class="btn bg-gradient-secondary w-100">Cancel</a>
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
    const form = document.getElementById("DeliveryForm");

    function simpan() {
        let order_id = document.getElementById("order_id").value;
        let shipping_date = document.getElementById("shipping_date").value;
        let tracking_code = document.getElementById("tracking_code").value;
        let status = document.getElementById("status").value;
        let errorMessages = [];

        if (order_id.trim() === "") {
            errorMessages.push("Order ID is required");
        }

        if (shipping_date.trim() === "") {
            errorMessages.push("Shipping Date is required");
        }

        if (tracking_code.trim() === "") {
            errorMessages.push("Tracking Code is required");
        }

        if (status.trim() === "") {
            errorMessages.push("Status is required");
        }

        if (errorMessages.length > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                html: errorMessages.join('<br>'), 
            });
        } else {
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to update this delivery?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                if (result.isConfirmed) {
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

