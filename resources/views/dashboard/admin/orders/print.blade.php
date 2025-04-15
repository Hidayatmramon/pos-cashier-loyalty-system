@extends('dashboard.main')
@section('dashboard')
    <style>
        .invoice-price {
            background: #f0f3f4;
            display: table;
            width: 100%
        }

        .invoice-price .invoice-price-left,
        .invoice-price .invoice-price-right {
            display: table-cell;
            padding: 20px;
            font-size: 20px;
            font-weight: 600;
            width: 75%;
            position: relative;
            vertical-align: middle
        }

        .invoice-price .invoice-price-left .sub-price {
            display: table-cell;
            vertical-align: middle;
            padding: 0 20px
        }

        .invoice-price small {
            font-size: 12px;
            font-weight: 400;
            display: block
        }

        .invoice-price .invoice-price-row {
            display: table;
            float: left
        }

        .invoice-price .invoice-price-right {
            width: 25%;
            background: #2d353c;
            color: #fff;
            font-size: 28px;
            text-align: right;
            vertical-align: bottom;
            font-weight: 300
        }

        .invoice-price .invoice-price-right small {
            display: block;
            opacity: .6;
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 12px
        }
    </style>
    <div class="container">
        <div class="row bg-light px-3 py-4 gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card p-4">
                    <div class="card-body p-0">
                        <div class="invoice-container">
                            <div class="invoice-header">
                                <!-- Row start -->
                                <div class="row gutters">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                        <div class="custom-actions-btns mb-5">
                                            <a href="{{ route('sale.print', $sale['id']) }}" class="btn btn-primary">
                                                <i class="icon-download"></i> Unduh
                                            </a>
                                            <a href="{{ route('sale.index') }}" class="btn btn-secondary">
                                                <i class="icon-printer"></i> Kembali
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row gutters">
                                    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                                        @if ($sale['customer'])
                                            <div class="invoice-details">
                                                <address>
                                                    <b>{{ $sale['customer']['no_hp'] }}</b><br>
                                                    MEMBER SEJAK :
                                                    {{($sale['customer']['created_at'])->format('d F Y') }}
                                                    <br>
                                                    MEMBER POIN : {{ $sale['customer'] ? $sale['customer']['poin'] : '0' }}
                                                </address>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                                        <div class="invoice-details">
                                            <div class="invoice-num">
                                                <div>Invoice - #{{ str_pad($sale['id'], 3, '0', STR_PAD_LEFT) }}</div>
                                                <div>{{ \Carbon\Carbon::now()->format('d F Y') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-body">
                                <div class="row gutters">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table custom-table m-0">
                                                <thead>
                                                    <tr>
                                                        <th>Produk</th>
                                                        <th>Harga</th>
                                                        <th>Quantity</th>
                                                        <th>Sub Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($sale['detailSale'] as $item)
                                                        <tr class="service">
                                                            <td class="tableitem">
                                                                <p class="itemtext">{{ $item['product']['name'] }}</p>  
                                                            </td>
                                                            <td class="tableitem">
                                                                <p class="itemtext">Rp.
                                                                    {{ number_format($item['product']['price'], '0', ',', '.') }}
                                                                </p>
                                                            </td>
                                                            <td class="tableitem">
                                                                <p class="itemtext">{{ $item['amount'] }}</p>
                                                            </td>
                                                            <td class="tableitem">
                                                                <p class="itemtext">Rp.
                                                                    {{ number_format($item['sub_total'], '0', ',', '.') }}
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-price">
                                <div class="invoice-price-left">
                                    <div class="invoice-price-row">
                                        <div class="sub-price">
                                            <small>POIN DIGUNAKAN</small>
                                            <span
                                                class="text-inverse">{{ $sale['poin'] }}</span>
                                        </div>
                                        <div class="sub-price">
                                            <small>KASIR</small>
                                            <span class="text-inverse">{{ Auth::user()->name }}</span>
                                        </div>
                                        <div class="sub-price">
                                            <small>KEMBALIAN</small>
                                            <span class="text-inverse">Rp. {{ number_format($sale['total_return'], '0', ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="invoice-price-right">
                                    <small>TOTAL</small>
                                    <span class="f-w-600" style="text-decoration: {{ $sale['poin'] > 0 ? 'line-through' : 'none' }};">Rp. {{ number_format($sale['total_price'], '0', ',', '.') }}</span>
                                    @if ($sale['poin'] > 0)
                                    <span class="f-w-600">Rp. {{ number_format($sale['total_price'], '0', ',', '.') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
