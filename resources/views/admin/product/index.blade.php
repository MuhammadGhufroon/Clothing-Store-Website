@extends('admin.dashboard.main')
@section('title', 'Product')
@section('sidenav')
    @include('admin.dashboard.sidenav')
@endsection
@section('page', 'Product')
@section('nav')
    @include('admin.dashboard.nav')

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <a href="{{ route('product.create') }}" class="btn btn-primary">Add New Item</a>
                        <h6>Table Product</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                            <thead>
                            <tr>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">No</th>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Product Category ID</th>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Product Category Name</th>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Name Product</th>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Description</th>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Price</th>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Stok_Quantity</th>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Image 1</th>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Image 2</th>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Image 3</th>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Image 4</th>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Image 5</th>
                              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                              <!-- <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Employed</th> -->
                              <th class="text-secondary opacity-7"></th>
                            </tr>
                          </thead>

                                <tbody>
                                    @foreach($products as $index => $product)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td class="text-center">{{ $product->category->id}}</td>
                                        <td class="text-center">{{ $product->category->category_name }}</td>
                                        <td class="text-center">{{ $product->product_name }}</td>                                  
                                        <td class="text-center">
                                            @php
                                                $description = $product->description;
                                                $description_chunks = chunk_split($description, 20, "<br>");
                                                echo $description_chunks;
                                            @endphp
                                        </td>

                                        <td class="text-center">{{ 'Rp ' . number_format($product->price, 0, ',', '.') }}</td>

                                        <td class="text-center">{{ $product->stok_quantity }}</td>
                                        <td>
                                  <img src="{{ asset($product->image1_url) }}" alt="{{ $product->product_name }}" style="max-width: 100px;">
                                </td>

                                <td>
                                  <img src="{{ asset($product->image2_url) }}" alt="{{ $product->product_name }}" style="max-width: 100px;">
                                </td>

                                <td>
                                  <img src="{{ asset($product->image3_url) }}" alt="{{ $product->product_name }}" style="max-width: 100px;">
                                </td>

                                <td>
                                  <img src="{{ asset($product->image4_url) }}" alt="{{ $product->product_name }}" style="max-width: 100px;">
                                </td>

                                <td>
                                  <img src="{{ asset($product->image5_url) }}" alt="{{ $product->product_name }}" style="max-width: 100px;">
                                </td>

                                        <td class="align-middle text-center text-sm">
                                            <!-- Action buttons -->
                                            <a href="{{ route('product.edit', $product->id) }}" class="badge badge-sm bg-gradient-success">Edit</a>
                                            <a href="#" onclick="event.preventDefault(); confirmDelete('{{ $product->product_name }}', '{{ $product->id }}')" class="badge badge-sm bg-gradient-danger">Delete</a>
                                            <form id="frmDelete{{ $product->id }}" action="{{ route('product.destroy', $product->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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
                        © <script>document.write(new Date().getFullYear())</script>, made with <i class="fa fa-heart"></i> by
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

    <input type="hidden" id="status" class="form-control" value="@isset($status){{$status}}@endisset">
    <input type="hidden" id="pesan" class="form-control" value="@isset($pesan){{$pesan}}@endisset">

    <!-- Display SweetAlert2 when success message is present -->
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{!! html_entity_decode(session('success')) !!}',
            });
        </script>
    @endif

    <!-- Confirm deletion using SweetAlert2 -->
    <script>
        function confirmDelete(name, productId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to delete ' + name + '. This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If user clicks 'Yes', submit form to delete data
                    document.getElementById('frmDelete' + productId).submit();
                }
            });
        }
    </script>
@endsection
