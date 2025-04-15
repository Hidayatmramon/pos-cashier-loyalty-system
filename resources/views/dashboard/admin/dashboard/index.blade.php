@extends('dashboard.main')
@section('dashboard')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 col-md-6 col-12 align-self-center">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb align-items-center">
                    <li class="breadcrumb-item">
                      <a class="text-muted text-decoration-none" >
                        <i class="ti ti-home fs-5"></i>
                      </a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">Dashboard</li>
                  </ol>
                </nav>
                <h2 class="mb-0 fw-bolder fs-8">Dashboard</h2>
              </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h3>Selamat Datang, {{ Auth::user()->name }}!</h3>
                        <div class="row">
                            <div class="col-6">
                                <canvas id="myChart" width="400" height="200"></canvas>
                            </div>
                            <div class="col-6">
                                <canvas id="myChart2" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        console.log(@json($labels));
        console.log(@json($data));
        console.log({!! json_encode($labelProducts) !!});
        console.log({!! json_encode($dataProducts) !!});
        const ctx = document.getElementById('myChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Jumlah Penjualan',
                    data: @json($data),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const ctx2 = document.getElementById('myChart2').getContext('2d');
        const myPieChart = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: {!! json_encode($labelProducts) !!},
                datasets: [{
                    label: 'Persentase Penjualan Produk',
                    data: {!! json_encode($dataProducts) !!},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Persentase Penjualan Produk'
                    }
                }
            }
        });
    </script>
@endpush
