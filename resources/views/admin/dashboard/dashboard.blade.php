@extends('admin.dashboard.main')
@section('title', 'Dashboard')
@section('sidenav')
    @include('admin.dashboard.sidenav')
@endsection
@section('page', 'Dashboard')
@section('nav')
    @include('admin.dashboard.nav')

    @php
    $payments = \App\Models\Payment::all();
    $orders = \App\Models\Order::all();
    $customers = \App\Models\Customer::all();
    $products = \App\Models\Product::all();
@endphp

<div class="container-fluid py-4">
      <div class="row ">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
            <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
    <i class="fas fa-money-bill-wave"></i>
</div>
<div class="text-end pt-1">
    <p class="text-sm mb-0 text-capitalize">Today's Payments</p>
    <h4 class="mb-0">Rp {{ number_format($payments->sum('amount'), 0, ',', '.') }}</h4>
</div>

            </div>
            
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+55% </span>than last week</p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
          <div class="card-header p-3 pt-2">
            <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
              <i class="material-icons opacity-10">calendar_today</i>
            </div>
            <div class="text-end pt-1">
              <p class="text-sm mb-0 text-capitalize">Today's Orders</p>
              <h4 class="mb-0">{{ $orders->count() }}</h4>
            </div>
          </div>

            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+3% </span>than last month</p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">person</i>
              </div>
              <div class="text-end pt-1">
                  <p class="text-sm mb-0 text-capitalize">Today's Customers</p>
                  <h4 class="mb-0">{{ $customers->count() }}</h4>
              </div>

            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              <p class="mb-0"><span class="text-danger text-sm font-weight-bolder">-2%</span> than yesterday</p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6">
          <div class="card">
          <div class="card-header p-3 pt-2">
          <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
            <i class="material-icons opacity-10">shopping_cart</i>
          </div>
          <div class="text-end pt-1">
            <p class="text-sm mb-0 text-capitalize">Today's Products</p>
            <h4 class="mb-0">{{ $products->count() }}</h4>
          </div>

            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+5% </span>than yesterday</p>
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-4">
  <div class="col-lg-12 mt-4 mb-3">
    <div class="card z-index-2">
      <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
        <div class="bg-gradient-dark shadow-dark border-radius-lg py-3 pe-1">
          <div class="chart">
            <canvas id="chart-line-tasks" class="chart-canvas" height="80"></canvas>
          </div>
        </div>
      </div>
      <div class="card-body">
        <h6 class="mb-0">Order Charts</h6>
        <p class="text-sm">Total number of orders paid over time</p>
        <hr class="dark horizontal">
        <div class="d-flex">
          <i class="material-icons text-sm my-auto me-1">schedule</i>
          <p class="mb-0 text-sm">Data last updated just now</p>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
 document.addEventListener('DOMContentLoaded', function() {
  var ctx = document.getElementById('chart-line-tasks').getContext('2d');

  var monthlyData = @json($monthlyData);

  var labels = monthlyData.map(function(item) {
    var date = new Date(item.month);
    var month = date.toLocaleString('default', { month: 'long' }); // Ambil nama bulan
    var day = date.getDate(); // Ambil tanggal
    var year = date.getFullYear(); // Ambil tahun
    return day + ' ' + month + ' ' + year; // Gabungkan tanggal, nama bulan, dan tahun
  });

  var data = monthlyData.map(function(item) {
    return item.count;
  });

  var chart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
      datasets: [{
        label: 'Number of Paid Orders', // Label untuk data angka di label y
        data: data,
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1,
        fill: false
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          // Label untuk sumbu y (vertikal)
          title: {
            display: true,
            text: 'Number of Orders'
          }
        },
        x: {
          ticks: {
            callback: function(value, index, values) {
              return labels[index]; // Tampilkan label dengan tanggal lengkap
            }
          },
          // Label untuk sumbu x (horizontal)
          title: {
            display: true,
            text: 'Date'
          }
        }
      }
    }
  });

  // Function to fetch new data from the server
  function fetchNewData() {
    fetch('/admin/dashboard/monthly-data')
      .then(response => response.json())
      .then(newData => {
        var newLabels = newData.map(function(item) {
          var date = new Date(item.month);
          var month = date.toLocaleString('default', { month: 'long' });
          var day = date.getDate();
          var year = date.getFullYear();
          return day + ' ' + month + ' ' + year;
        });

        var newDataPoints = newData.map(function(item) {
          return item.count;
        });

        // Update chart data
        chart.data.labels = newLabels;
        chart.data.datasets[0].data = newDataPoints;
        chart.update();
      });
  }

  // Set interval to fetch new data every 5 minutes (300000 ms)
  setInterval(fetchNewData, 300000);
});

</script>





      
      <footer class="footer py-4  ">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
              <div class="copyright text-center text-sm text-muted text-lg-start">
                © <script>
                  document.write(new Date().getFullYear())
                </script>,
                made with <i class="fa fa-heart"></i> by
                <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative Tim</a>
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(Auth::check() && !session('loginPopupDisplayed'))
    @if(Auth::user()->roles === 'admin' || Auth::user()->roles === 'owner')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Tampilkan SweetAlert hanya jika pengguna berhasil login dan pop-up belum ditampilkan sebelumnya
                Swal.fire({
                    icon: 'success',
                    title: 'Login Successful!',
                    text: 'Welcome, {{ Auth::user()->name }}!',
                    showConfirmButton: false,
                    timer: 1500 // Durasi pop-up dalam milidetik
                });
            });
        </script>
        <?php session(['loginPopupDisplayed' => true]); ?>
    @endif
@endif

<script>
    // Check if there's a success message from the backend
    @if(session('success'))
        // Display SweetAlert with success message
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 1500
        });
    @endif
</script>


@endsection