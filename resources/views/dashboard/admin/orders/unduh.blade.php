<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bukti Penjualan</title>
    <style>
        #back-wrap {
            margin: 30px auto 0 30px;
            width: 450px;
            display: flex;
            justify-content: flex-end;
        }

        .btn-back {
            width: fit-content;
            padding: 8px 15px;
            color: #fff;
            background: #666;
            border-radius: 5px;
            text-decoration: none;
        }

        #receipt {
            box-shadow: 5px 10px 15px rgba(0, 0, 0, 0.5);
            padding: 20px;
            margin: 30px auto 0 auto;
            width: 500px;
            background: #fff;
        }

        h2 {
            font-size: .9rem;
        }

        p {
            font-size: .8rem;
            color: #666;
            line-height: 1.2rem;
        }

        #top {
            margin-top: 25px;
        }

        #top .info {
            text-align: center;
            margin: 20px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 5px 0 5px 15px;
            border: 1px dolif #eee;
        }

        .tabletitle {
            font-size: .5rem;
            background: #eee;
        }

        .service {
            border-bottom: 1px solid #eee;
        }

        .itemtext {
            font-size: .7rem;
        }

        #legalcopy {
            margin-top: 15px;
        }

        .btn-print {
            float: right;
            color: #333;
        }
    </style>
</head>

<body>
    <div id="receipt">
        <b id="top">
            <h2>ramones indo</h2>
        </b>
        <div id="mid">
            <div class="info" style="display: flex; justify-content: space-between;">
                <div>
                    <small>
                        Member Status : {{ $sale['customer'] ? 'Member' : 'Bukan Member' }}</br>
                        @if ($sale['customer'])
                            
                        No. HP : {{ $sale['customer']['no_hp'] }}</br>
                    </small>
                </div>
                <div>
                    <small>
                        Bergabung Sejak :
                        {{\Carbon\Carbon::parse($sale['created_at'])->format('d F Y')}}

                        <br>
                        Poin Member : {{$sale['customer']['poin'] }}
                    </small>
                </div>
                @else
                
                @endif
            </div>
            <div id="bot" style="margin-top: 20px">
                <div id="table">
                    <table>
                        <tr class="tabletitle">
                            <td class="item">
                                <h2>Nama Produk</h2>
                            </td>
                            <td class="item">
                                <h2>QTy</h2>
                            </td>
                            <td class="item">
                                <h2>Harga</h2>
                            </td>
                            <td class="item">
                                <h2>Sub Total</h2>
                            </td>
                        </tr>
                        @foreach ($sale['detailSale'] as $data)
                            <tr class="service">
                                <td class="tableitem">
                                    <p class="itemtext">{{ $data['product']['name'] }}</p>
                                </td>
                                <td class="tableitem">
                                    <p class="itemtext">{{ $data['amount'] }}</p>
                                </td>
                                <td class="tableitem">
                                    <p class="itemtext">Rp.
                                        {{ number_format($data['product']['price'], '0', ',', '.') }}</p>
                                </td>
                                <td class="tableitem">
                                    <p class="itemtext">Rp. {{ number_format($data['sub_total'], '0', ',', '.') }}</p>
                                </td>
                            </tr>
                        @endforeach
                        <tr class="tabletitle">
                            <td></td>
                            <td></td>
                            <td>
                                <h2>Total Harga</h2>
                            </td>
                            <td>
                                <h2>Rp. {{ number_format($sale['total_price'], '0', ',', '.') }}</h2>
                            </td>
                        </tr>
                        <tr class="tabletitle">
                            <td>Poin Digunakan</td>
                            <td>{{ $sale['poin'] }}</td>
                            <td>
                                <h2>Harga Setelah Poin</h2>
                            </td>
                            <td>
                                <h2>Rp. {{ number_format($sale['total_poin'], '0', ',', '.') }}</h2>
                            </td>
                        </tr>
                        <tr class="tabletitle">
                            <td></td>
                            <td></td>
                            <td>
                                <h2>Total Kembalian</h2>
                            </td>
                            <td>
                                <h2>Rp. {{ number_format($sale['total_return'], '0', ',', '.') }}</h2>
                            </td>
                        </tr>
                    </table>
                </div>
                <div id="legalcopy">
                    <center>
                        <p>{{ $sale['created_at'] }} | {{ $sale['user']['name'] }}</p>
                        <p class="legal"><strong>Terima kasih atas pembelian Anda!</strong></p>
                    </center>
                </div>
            </div>
        </div>
</body>

</html>
