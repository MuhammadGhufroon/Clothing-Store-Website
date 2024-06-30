@extends('admin.dashboard.main')
@section('title', 'Orders')
@section('sidenav')
    @include('admin.dashboard.sidenav')
@endsection
@section('page', 'Orders')
@section('nav')
    @include('admin.dashboard.nav')

    <div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Table of Orders</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">No</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Receipt Code</th> <!-- Menambahkan kolom Order ID -->
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Customer</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Order Date</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Quantity</th> <!-- Menambahkan kolom Quantity -->
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Total Amount</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Status</th>      
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Delivery</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $index => $order)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="text-center">{{ $order->id }}</td> <!-- Menampilkan Order ID -->
                                <td class="text-center">{{ $order->customer->name }}</td>
                                <td class="text-center">{{ $order->order_date }}</td>
                                <td class="text-center">{{ $order->quantity }}</td> <!-- Menampilkan Quantity -->
                                <td class="text-center">{{ 'Rp ' . number_format($order->total_amount, 0, ',', '.') }}</td>

                                <td class="text-center">
                                    @if($order->status === 'pending')
                                        <span class="text-danger font-weight-bold">{{ $order->status }}</span>
                                    @elseif($order->status === 'Unpaid')
                                        <span class="text-warning font-weight-bold">{{ $order->status }}</span>
                                    @elseif($order->status === 'Paid')
                                        <span class="text-success font-weight-bold">{{ $order->status }}</span>
                                    @else
                                        <span>{{ $order->status }}</span>
                                    @endif
                                </td>
                                
                                <td class="text-center">
                                    @if($order->delivery)
                                        @if($order->delivery->status === 'On the way' || $order->delivery->status === 'Package has arrived')
                                            <button type="button" class="btn btn-primary" disabled>Delivered</button>
                                        @else
                                            <form id="delivery-form-{{ $order->id }}" action="{{ route('order.deliver', $order->id) }}" method="POST">
                                                @csrf
                                                <button type="button" class="btn btn-primary" onclick="handleDelivery({{ $order->id }}, '{{ $order->status }}')">Delivery</button>
                                            </form>
                                        @endif
                                    @else
                                        <button type="button" class="btn btn-primary" disabled>Delivered</button>
                                    @endif
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
        function confirmDelete(orderId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to delete the order. This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('frmDelete' + orderId).submit();
                }
            });
        }
    </script>

    <!-- Tambahkan SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<!-- Tambahkan script JavaScript -->
<script>
    function handleDelivery(orderId, orderStatus) {
        if (orderStatus === 'pending' || orderStatus === 'Unpaid') {
            Swal.fire({
                icon: 'warning',
                title: 'Cannot Deliver',
                text: 'This order cannot be delivered because it is pending or unpaid.',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        } else {
            // Jika status tidak 'Pending' atau 'Unpaid', kirim form delivery
            document.getElementById('delivery-form-' + orderId).submit();
        }
    }
</script>
@endsection
