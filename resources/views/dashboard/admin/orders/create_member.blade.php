@extends('dashboard.main')
@section('dashboard')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 col-md-6 col-12 align-self-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb align-items-center">
                        <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none">
                                <i class="ti ti-home fs-5"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Penjualan</li>
                    </ol>
                </nav>
                <h2 class="mb-0 fw-bolder fs-8">Penjualan</h2>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('sale.store.customer') }}" method="POST">
                            @csrf
                            @method('POST')
                            @if (Session::get('error'))
                                <div class="alert alert-danger">
                                    {{ Session::get('error') }}
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="table table-bordered">
                                        <table>
                                            <tr class="tabletitle">
                                                <td class="item">
                                                    Nama Produk
                                                </td>
                                                <td class="item">
                                                    QTy
                                                </td>
                                                <td class="item">
                                                    Harga
                                                </td>
                                                <td class="item">
                                                    Sub Total
                                                </td>
                                            </tr>
                                            @foreach ($sale['detailSale'] as $item)
                                                <tr class="service">
                                                    <td class="tableitem">
                                                        <p class="itemtext">{{ $item['product']['name'] }}</p>
                                                    </td>
                                                    <td class="tableitem">
                                                        <p class="itemtext">{{ $item['amount'] }}</p>
                                                    </td>
                                                    <td class="tableitem">
                                                        <p class="itemtext">Rp.
                                                            {{ number_format($item['product']['price'], '0', ',', '.') }}</p>
                                                    </td>
                                                    <td class="tableitem">
                                                        <p class="itemtext">Rp. {{ number_format($item['sub_total'], '0', ',', '.') }}</p>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr class="tabletitle">
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <h4>Total Harga</h4>
                                                </td>
                                                <td>
                                                    <h4>Rp. {{ number_format($sale['total_price'], '0', ',', '.') }}</h4>
                                                </td>
                                            </tr>
                                            <tr class="tabletitle">
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <h4>Total Bayar</h4>
                                                </td>
                                                <td>
                                                    <h4>Rp. {{ number_format($sale['total_pay'], '0', ',', '.') }}</h4>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="row">
                                        <input type="hidden" name="sale_id" value="{{ $sale['id'] }}">
                                        <input type="hidden" name="customer_id" value="{{ $sale['customer_id'] }}">
                                        <div class="form-group">
                                            <label for="name" class="form-label">Nama Member (identitas)</label>
                                            <input type="text" name="name" id="name" class="form-control" required value="{{ $sale['customer']['name'] }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="poin" class="form-label">Poin</label>
                                            <input type="text" name="poin" id="poin" value="{{ $sale['customer']['poin'] }}" disabled class="form-control">
                                        </div>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input" type="checkbox" value="Ya" id="check2" {{ $countSale > 1 ? '' : 'disabled' }} name="check_poin">
                                            <label class="form-check-label" for="check2">
                                                Gunakan poin
                                            </label>
                                            <small class="text-danger">{{ $countSale > 1 ? '' : 'Poin tidak dapat digunakan pada pembelanjaan pertama.'}}</small>
                                        </div>
                                    </div>
                                    <div class="row text-end">
                                        <div class="col-md-12">
                                            <button class="btn btn-primary" type="submit">Selanjutnya</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
