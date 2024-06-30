@extends('admin.dashboard.main')
@section('title', 'Delivery')
@section('sidenav')
    @include('admin.dashboard.sidenav')
@endsection
@section('page', 'Delivery')
@section('nav')
    @include('admin.dashboard.nav')

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">                       
                        <h6>Delivery Table</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Receipt Code</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Customer Name</th> <!-- Menambahkan kolom Customer Name -->
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Shipping Date</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Tracking Code</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Courier</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Loop through Delivery data -->
                                @foreach($deliveries as $index => $delivery)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center">{{ $delivery->order->id }}</td>
                                    <td class="text-center">{{ $delivery->order->customer->name }}</td> <!-- Menampilkan Customer Name -->
                                    <td class="text-center">{{ $delivery->shipping_date }}</td>
                                    <td class="text-center">{{ $delivery->tracking_code }}</td>                                   
                                                                    
                                    <td class="text-center">
                                        @php
                                            $oneWeekAgo = \Carbon\Carbon::now()->subWeek();
                                            $status = $delivery->status;
                                            if ($delivery->status === 'On the way' && $delivery->updated_at < $oneWeekAgo) {
                                                $status = 'Package has arrived';
                                            }
                                        @endphp
                                        {{ $status }}
                                    </td>
                                    <td class="text-center">{{ $delivery->courier }}</td>   
                                    <td class="align-middle text-center text-sm">                                           
                                        <form id="frmDelete{{ $delivery->id }}" action="{{ route('delivery.destroy', $delivery->id) }}" method="POST" style="display: none;">
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


<input type="hidden" id="status" class="form-control" value="@isset($status){{$status}}@endisset">
    <input type="hidden" id="pesan" class="form-control" value="@isset($pesan){{$pesan}}@endisset">
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{!! html_entity_decode(session('success')) !!}',
        });
    </script>
    @endif

    <script>
        function confirmDelete(deliveryId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to delete this delivery. This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('frmDelete' + deliveryId).submit();
                }
            });
        }
    </script>
    
@endsection
