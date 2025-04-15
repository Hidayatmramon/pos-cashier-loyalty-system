@extends('dashboard.main')

@section('dashboard')
<div class="container-fluid">
    <div class="page-titles mb-7 mb-md-5">
        <div class="row">
            <div class="col-lg-8 col-md-6 col-12 align-self-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb align-items-center">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}" class="text-muted text-decoration-none">
                                <i class="ti ti-home fs-5"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('product.index') }}" class="text-muted">Product</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Produk</li>
                    </ol>
                </nav>
                <h2 class="mb-0 fw-bolder fs-8">Edit Produk</h2>
            </div>
        </div>
    </div>

    <div class="card card-body">
        <form class="form-horizontal form-material mx-2" method="POST" action="{{ route('product.update', $product->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-12">Nama Produk <span class="text-danger">*</span></label>
                        <div class="col-md-12">
                            <input type="text" name="name" value="{{ $product->name }}" class="form-control form-control-line @error('name') is-invalid @enderror">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-12">Gambar Produk</label>
                        <div class="col-md-12">
                            <input type="file" name="img" class="form-control form-control-line @error('img') is-invalid @enderror" accept="image/*">
                            @error('img')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            @if($product->img)
                                <small class="text-muted d-block mt-1">Gambar saat ini: <a href="{{ asset('storage/product/' . $product->img) }}" target="_blank">Lihat</a></small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-12">Harga <span class="text-danger">*</span></label>
                        <div class="col-md-12">
                            <input type="text" name="price" id="price" value="{{ 'Rp. ' . number_format($product->price, 0, ',', '.') }}" class="form-control form-control-line @error('price') is-invalid @enderror">
                            @error('price')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-12">Stok <span class="text-danger">*</span></label>
                        <div class="col-md-12">
                            <input type="number" name="stock" value="{{ $product->stock }}"  class="form-control form-control-line @error('stock') is-invalid @enderror">
                            @error('stock')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-end">
                <div class="col text-end">
                    <a href="{{ route('product.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary w-25">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('script')
<script>
    $('#price').keyup(function (e) {
        e.target.value = formatRupiah(this.value, 'Rp. ');
    });

    function formatRupiah(angka, prefix)
    {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split    = number_string.split(','),
            sisa     = split[0].length % 3,
            rupiah     = split[0].substr(0, sisa),
            ribuan     = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
</script>
@endpush
