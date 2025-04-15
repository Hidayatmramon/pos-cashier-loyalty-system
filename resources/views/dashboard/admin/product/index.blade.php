@extends('dashboard.main')

@section('dashboard')
<div class="container-fluid">
    <div class="page-titles mb-7 mb-md-5">
        <div class="row">
            <div class="col-lg-8 col-md-6 col-12 align-self-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb align-items-center">
                        <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none">
                                <i class="ti ti-home fs-5"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Product</li>
                    </ol>
                </nav>
                <h2 class="mb-0 fw-bolder fs-8">Product</h2>
            </div>
        </div>
    </div>

    <div class="widget-content searchable-container list">
        <div class="card card-body">
            <div class="row">
                <div class="col-md-4 col-xl-3">
                    
                </div>
                @if (Auth::user()->role == "admin")
                <div class="col-md-8 col-xl-9 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                    <a href="{{ route('product.create') }}" class="btn btn-primary d-flex align-items-center">
                        <i class="ti ti-plus text-white me-1 fs-5"></i> Tambah Produk
                    </a>
                </div>
                @endif
            </div>
        </div>

        <div class="card card-body">
            <div class="table-responsive">
                <table class="table search-table align-middle text-nowrap">
                    <thead class="header-item">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Stock</th>
                            @if (Auth::user()->role == "admin")
                                <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach ($products as $product)
                        <tr class="search-items">
                            <th>{{ $i++ }}</th>
                            <td style="width: 80px;">
                                <img src="{{ asset('storage/product/'.$product['img']) }}" class="rounded" width="60">
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ 'Rp. ' . number_format($product->price, 0, ',', '.') }}</td>
                            <td>{{ $product->stock }}</td>
                            @if (Auth::user()->role == "admin")
                            <td>
                                <div class="action-btn">
                                    <form action="{{ route('product.edit', $product->id) }}" method="get" class="d-inline">
                                        <button type="submit" class="btn btn-warning btn-sm me-1">
                                            <i class="ti ti-pencil fs-5"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('product.destroy', $product->id) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus produk ini?')">
                                            <i class="ti ti-trash fs-5"></i>
                                        </button>
                                    </form>
                                </div>


                            </td>
                            @endif
                        </tr>
                        @endforeach
                        @if (count($products) == 0)
                            <tr><td colspan="6" class="text-center">Tidak ada produk ditemukan</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
