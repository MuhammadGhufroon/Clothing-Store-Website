@extends('admin.dashboard.main')
@section('title', 'Create Discount')
@section('sidenav')
    @include('admin.dashboard.sidenav')
@endsection
@section('page', 'Create Discount')
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
    <form action="{{ route('discount.store') }}" method="post" id="DiscountForm" enctype="multipart/form-data">
        @csrf
        <div class="mb-3 ms-3 me-3">
            <label for="category_discount_id" class="form-label">Category</label>
            <div class="border-contrast p-1 rounded"> 
                <select class="form-select border-0" id="category_discount_id" name="category_discount_id">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                    @endforeach
                </select>
            </div>
            @error('category_discount_id')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 ms-3 me-3">
            <label for="product_id" class="form-label">Product</label>
            <div class="border-contrast p-1 rounded"> 
                <select class="form-select border-0" id="product_id" name="product_id">
                    <option value="">Select Product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                    @endforeach
                </select>
            </div>
            @error('product_id')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 ms-3 me-3">
            <label for="start_date" class="form-label">Start Date</label>
            <div class="border-contrast p-1 rounded"> 
                <input type="datetime-local" class="form-control border-0" id="start_date" name="start_date">
            </div>
            @error('start_date')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 ms-3 me-3">
            <label for="end_date" class="form-label">End Date</label>
            <div class="border-contrast p-1 rounded"> 
                <input type="datetime-local" class="form-control border-0" id="end_date" name="end_date" >
            </div>
            @error('end_date')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 ms-3 me-3">
            <label for="percentage" class="form-label">Percentage</label>
            <div class="border-contrast p-1 rounded"> 
                <input type="number" class="form-control border-0" id="percentage" name="percentage" value="{{ old('percentage') }}">
            </div>
            @error('percentage')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <div class="row ms-3 me-3 justify-content-end">
            <div class="col-3">
                <a href="{{ route('discount.index') }}" class="btn bg-gradient-secondary w-100">Cancel</a>
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
    const form = document.getElementById("DiscountForm");

    function simpan() {
        let category_id = document.getElementById("category_discount_id").value;
        let product_id = document.getElementById("product_id").value;
        let start_date = document.getElementById("start_date").value;
        let end_date = document.getElementById("end_date").value;
        let percentage = document.getElementById("percentage").value;

        let errorMessages = [];

                if (category_id.trim() === "") {
            errorMessages.push("Category is required");
        }

        if (product_id.trim() === "") {
            errorMessages.push("Product is required");
        }

        if (start_date.trim() === "") {
            errorMessages.push("Start Date is required");
        }

        if (end_date.trim() === "") {
            errorMessages.push("End Date is required");
        }

        if (percentage.trim() === "") {
            errorMessages.push("Percentage is required");
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
                text: 'Do you want to create this product review?',
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

