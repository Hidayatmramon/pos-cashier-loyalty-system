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
                        <div class="card d-block m-auto text-center">
                            <div class="card-header">
                                Total Penjualan Hari Ini
                            </div>
                            <div class="card-body">
                                <h3 class="card-title">{{ $sales }}</h3>
                                <p class="card-text">Jumlah total penjualan yang terjadi hari ini.</p>
                            </div>
                            <div class="card-footer text-muted">
                                Terakhir diperbarui: {{ \Carbon\Carbon::now()->format('d M Y H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
