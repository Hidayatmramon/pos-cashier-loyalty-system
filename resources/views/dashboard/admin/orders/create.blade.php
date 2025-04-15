@extends('dashboard.main')
@section('dashboard')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 col-md-6 col-12 align-self-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb align-datas-center">
                        <li class="breadcrumb-data">
                            <a class="text-muted text-decoration-none">
                                <i class="ti ti-home fs-5"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-data" aria-current="page">Penjualan</li>
                    </ol>
                </nav>
                <h2 class="mb-0 fw-bolder fs-8">Penjualan</h2>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <section>
                            <div class="text-center container">
                                <div class="row" id="product-list">
                                </div>
                            </div>
                        </section>

                    </div>
                    <div class="row fixed-bottom d-flex justify-content-end align-content-center"
                        style="margin-left: 18%; width: 83%; height: 70px; border-top: 3px solid #EEE4B1; background-color: white;">
                        <div class="col text-center" style="margin-right: 50px;">
                            <form action="{{ route('sale.store') }}" method="post">
                                @csrf
                                <div id="shop"></div>
                                <button class="btn btn-primary">Selanjutnya</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            let products = @json($products);
            $.each(products, function(key, data) {
                $("#product-list").append(`
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="bg-image hover-zoom ripple ripple-surface ripple-surface-light">
                        <img src="{{ asset('storage/product/`+data.img+`') }}" class="w-50" />
                    </div>
                    <div class="card-body">
                        <h5 class="card-title mb-3">` + data.name + `</h5>
                        <p>Stok ` + data.stock + `</p>
                        <h6 class="mb-3">Rp. ` + formatRupiah(data.price) + `</h6>
                        <p id="price_` + data.id + `" hidden>` + data.price + `</p>
                        <center>
                            <table>
                                <tr>
                                    <td style="padding: 0px 10px 0px 10px; cursor: pointer;" id="minus_` + data.id + `"><b>-</b></td>
                                    <td style="padding: 0px 10px 0px 10px;" class="num" id="quantity_` + data.id + `">0</td>
                                    <td style="padding: 0px 10px 0px 10px; cursor: pointer;" id="plus_` + data.id + `"><b>+</b></td>
                                </tr>
                            </table>
                        </center>
                        <br>
                        <p>Sub Total <b><span id="total_` + data.id + `">Rp. 0</span></b></p>
                    </div>
                </div>
            </div>
        `);

                function formatRupiah(angka) {
                    let numberString = angka.toString();
                    let sisa = numberString.length % 3;
                    let rupiah = numberString.substr(0, sisa);
                    let ribuan = numberString.substr(sisa).match(/\d{3}/g);

                    if (ribuan) {
                        let separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                    }

                    return rupiah;
                }

                $('#plus_' + data.id).click(function(e) {
                    const elem = $(this).prev();
                    const getId = elem.attr("id").split("_")[1];
                    const price = $("#price_" + getId).html();
                    let qty = parseInt(elem.html()) + 1;

                    if (qty > data.stock) {
                        alert("Stok kurang!");
                        elem.html(data.stock); 
                        qty = data.stock; 
                    }

                    elem.html(qty);
                    let total = price * qty;
                    $("#total_" + data.id).html("Rp. " + formatRupiah(
                    total));

                    if (qty > 0) {
                        let shop = `` + data.id + `;` + data.name + `;` + data.price + `;` + qty +
                            `;` + total + `;`;
                        $('#shop').append(`
                    <input name="shop[]" value="` + shop + ` " type="text" hidden />
                `);
                    }
                });

                $('#minus_' + data.id).click(function(e) {
                    const elem = $(this).next();
                    const getId = elem.attr("id").split("_")[1]; 
                    const price = $("#price_" + getId).html(); 
                    let qty = parseInt(elem.html());

                    if (qty > 0) {
                        qty--;
                    }
                    elem.html(qty);
                    let total = price * qty;
                    $("#total_" + data.id).html("Rp. " + formatRupiah(
                    total)); 

                    if (qty > 0) {
                        let shop = `` + data.id + `;` + data.name + `;` + data.price + `;` + qty +
                            `;` + total + `;`;
                        $('#shop').append(`
                    <input name="shop[]" value="` + shop + ` " type="text" hidden />
                `);
                    }
                });
            });
        });
    </script>
@endpush
