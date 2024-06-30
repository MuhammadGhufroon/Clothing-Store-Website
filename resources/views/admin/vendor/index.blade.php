@extends('admin.dashboard.main')
@section('title', 'Vendors')
@section('sidenav')
    @include('admin.dashboard.sidenav')
@endsection
@section('page', 'Vendors')
@section('nav')
    @include('admin.dashboard.nav')

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <a href="{{ route('vendor.create') }}" class="btn btn-primary">Add New Item</a>
                        <h6>Table of Vendors</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">No</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Email</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Phone</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Address</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($vendors as $index => $vendor)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td class="text-center">{{ $vendor->name }}</td>
                                            <td class="text-center">{{ $vendor->email }}</td>
                                            <td class="text-center">{{ $vendor->phone }}</td>
                                            <td class="text-center">{{ $vendor->address }}</td>
                                            <td class="align-middle text-center text-sm">
                                                <!-- Tombol Edit -->
                                                <a href="{{ route('vendor.edit', $vendor->id) }}" class="badge badge-sm bg-gradient-success">Edit</a>
                                                
                                                <!-- Tombol Delete -->
                                                <a href="#" onclick="event.preventDefault(); confirmDelete('{{ $vendor->name }}', '{{ $vendor->id }}')" class="badge badge-sm bg-gradient-danger">Delete</a>
                                                <form id="frmDelete{{ $vendor->id }}" action="{{ route('vendor.destroy', $vendor->id) }}" method="POST" style="display: none;">
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
    
    <!-- SweetAlert for success message -->
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{!! html_entity_decode(session('success')) !!}',
            });
        </script>
    @endif

    <!-- SweetAlert for delete confirmation -->
    <script>
        function confirmDelete(name, nameId) {
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
                    // If user clicks 'Yes', submit the form to delete the data
                    document.getElementById('frmDelete' + nameId).submit();
                }
            });
        }
    </script>
@endsection
