@extends('admin.dashboard.main')
@section('title', 'Create Product')
@section('sidenav')
    @include('admin.dashboard.sidenav')
@endsection
@section('page', 'Create Product')
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
            <form action="{{ route('product.store') }}" method="post" id="ProductForm" enctype="multipart/form-data">
                @csrf
                <div class="mb-3 ms-3 me-3">
                    <label for="product_category_id" class="form-label">Product Category</label>
                    <div class="border-contrast p-1 rounded">
                        <select class="form-select border-0" id="product_category_id" name="product_category_id" aria-label="product_category_id">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('product_category_id')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 ms-3 me-3">
                    <label for="product_name" class="form-label">Product Name</label>
                    <div class="border-contrast p-1 rounded"> 
                        <input type="text" class="form-control border-0" id="product_name" name="product_name" placeholder="Name" aria-label="product_name" value="{{ old('product_name') }}">
                    </div>
                    @error('product_name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 ms-3 me-3">
                    <label for="description" class="form-label">Description</label>
                    <div class="border-contrast p-1 rounded"> 
                        <textarea class="form-control border-0" id="description" name="description" placeholder="Description" aria-label="description">{{ old('description') }}</textarea>
                    </div>
                    @error('description')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 ms-3 me-3">
                    <label for="price" class="form-label">Price</label>
                    <div class="border-contrast p-1 rounded"> 
                        <input type="number" class="form-control border-0" id="price" name="price" placeholder="Price" aria-label="price" value="{{ old('price') }}">
                    </div>
                    @error('price')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>


                <div class="mb-3 ms-3 me-3">
                    <label for="image1_url" class="form-label">Image 1</label>
                    <div class="border-contrast p-1 rounded"> 
                        <input type="file" class="form-control border-0" id="image1_url" name="image1_url" accept="image/*" aria-label="image1_url" onchange="previewImage(event, 'preview-image1')">
                    </div>
                    @error('image1_url')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                    <img id="preview-image1" src="" alt="Preview Image" style="max-width: 200px; margin-top: 5px; display: none;">
                </div>

                <div class="mb-3 ms-3 me-3">
                    <label for="image2_url" class="form-label">Image 2</label>
                    <div class="border-contrast p-1 rounded"> 
                        <input type="file" class="form-control border-0" id="image2_url" name="image2_url" accept="image/*" aria-label="image2_url" onchange="previewImage(event, 'preview-image2')">
                    </div>
                    @error('image2_url')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                    <img id="preview-image2" src="" alt="Preview Image" style="max-width: 200px; margin-top: 5px; display: none;">
                </div>

                <div class="mb-3 ms-3 me-3">
                    <label for="image3_url" class="form-label">Image 3</label>
                    <div class="border-contrast p-1 rounded"> 
                        <input type="file" class="form-control border-0" id="image3_url" name="image3_url" accept="image/*" aria-label="image3_url" onchange="previewImage(event, 'preview-image3')">
                    </div>
                    @error('image3_url')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                    <img id="preview-image3" src="" alt="Preview Image" style="max-width: 200px; margin-top: 5px; display: none;">
                </div>

                <div class="mb-3 ms-3 me-3">
                    <label for="image4_url" class="form-label">Image 4</label>
                    <div class="border-contrast p-1 rounded"> 
                        <input type="file" class="form-control border-0" id="image4_url" name="image4_url" accept="image/*" aria-label="image4_url" onchange="previewImage(event, 'preview-image4')">
                    </div>
                    @error('image4_url')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                    <img id="preview-image4" src="" alt="Preview Image" style="max-width: 200px; margin-top: 5px; display: none;">
                </div>

                <div class="mb-3 ms-3 me-3">
                    <label for="image5_url" class="form-label">Image 5</label>
                    <div class="border-contrast p-1 rounded"> 
                        <input type="file" class="form-control border-0" id="image5_url" name="image5_url" accept="image/*" aria-label="image5_url" onchange="previewImage(event, 'preview-image5')">
                    </div>
                    @error('image5_url')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                    <img id="preview-image5" src="" alt="Preview Image" style="max-width: 200px; margin-top: 5px; display: none;">
                </div>

                

                <!-- Tambahkan input fields lainnya sesuai kebutuhan -->
                
                <div class="row ms-3 me-3 justify-content-end">
                    <div class="col-3">
                        <a href="{{ route('product.index') }}" class="btn bg-gradient-secondary w-100">Cancel</a>
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
    function previewImage(event, previewId) {
        const preview = document.getElementById(previewId);
        preview.style.display = "block";
        preview.src = URL.createObjectURL(event.target.files[0]);
    }

    const btnSave = document.getElementById("save");
    const form = document.getElementById("ProductForm");

    function simpan() {
        let product_category_id = document.getElementById("product_category_id").value;
        let product_name = document.getElementById("product_name").value;
        let description = document.getElementById("description").value;
        let price = document.getElementById("price").value;
        let image1_url = document.getElementById("image1_url").value;
        let image2_url = document.getElementById("image2_url").value;
        let image3_url = document.getElementById("image3_url").value;
        let image4_url = document.getElementById("image4_url").value;
        let image5_url = document.getElementById("image5_url").value;

        // Membuat array untuk menyimpan pesan kesalahan
        let errorMessages = [];

        // Memeriksa input dan menambahkan pesan kesalahan ke array jika diperlukan
        if (product_category_id.trim() === "") {
            errorMessages.push("Product category is required");
        }
        if (product_name.trim() === "") {
            errorMessages.push("Product name is required");
        }
        if (description.trim() === "") {
            errorMessages.push("Description is required");
        }
        if (price.trim() === "") {
            errorMessages.push("Price is required");
        }
      
        if (
            image1_url.trim() === "" &&
            image2_url.trim() === "" &&
            image3_url.trim() === "" &&
            image4_url.trim() === "" &&
            image5_url.trim() === ""
        ) {
            errorMessages.push("At least one photo must be uploaded");
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
                text: 'Do you want to create this product?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, create it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika pengguna mengklik 'Yes', submit form untuk membuat produk
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

