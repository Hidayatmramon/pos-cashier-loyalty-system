<?php

namespace App\Http\Controllers;

use App\Exports\SaleExport;
use App\Models\Customer;
use App\Models\DetailSale;
use App\Models\Product;
use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Maatwebsite\Excel\Facades\Excel;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $sales = Sale::with('customer', 'detailSale', 'user')->orderBy('updated_at', 'DESC')->get();
        } else {
            $sales = Sale::where('user_id', Auth::user()->id)->with('customer', 'detailSale', 'user')->orderBy('updated_at', 'DESC')->get();
        }

        return view('dashboard.admin.orders.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::orderBy('name', 'ASC')->get();
        return view('dashboard.admin.orders.create', compact('products'));
    }

    public function createMember($saleId)
    {
        $sale = Sale::find($saleId);
        $title = 'Pembayaran';
        $page = 'sale';
        $countSale = Sale::where('customer_id', $sale['customer_id'])->count();
        return view('dashboard.admin.orders.create_member', compact('sale', 'title', 'page', 'countSale'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $products = [];
        $shop = [];
        foreach ($request->shop as $item) {
            $tes = explode(";", $item);
            $products[$tes[0]][] = $item;
        }
        foreach ($products as $e => $i) {
            array_push($shop, end($i));
        }

        return view('dashboard.admin.orders.detail', compact('shop'));
    }

    public function storeCustomer(Request $request)
    {
        $customer = Customer::where('id', $request->customer_id)->first();
        if ($customer['name'] == NULL) {
            $customer->update(['name' => $request->name]);
        }
        $sale = Sale::where('id', $request->sale_id)->first();

        if ($request->check_poin == "Ya") {
            $total = $sale->total_price - $customer->poin;
            $sale->update([
                "poin" => $customer->poin,
                "total_poin" => $total,
                "total_price" => (int)$sale['total_price'] - $customer->poin,
                "total_return" => (int)$sale['total_pay'] - $total,
            ]);
            $customer->update([ "poin" => 0 ]);
        }

        return redirect()->route('sale.show.print', $sale['id']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale, $id)
    {
        $sale = Sale::where('id', $id)->first();
        $detailSale = DetailSale::where('sale_id', $id)->get();
        $customer = Customer::where('id', $sale->customer_id)->first();


        $deleteSale = $sale->delete();
        foreach ($detailSale as $item) {
            $updateStock = $item->product->update([
                'stock' => $item->product->stock + $item->amount,
            ]);

            $deleteDetailSale = $item->delete();
        }
        $deleteCustomer = $customer->delete();

        if ($deleteSale && $deleteDetailSale && $deleteCustomer && $updateStock) {
            return redirect()->route('sale.index')->with('success', 'Berhasil Menghapus Data Penjualan!');
        } else {
            return redirect()->route('sale.index')->with('error', 'Gagal Menghapus Data Penjualan!');
        }
    }

    public function detailShop(Request $request)
    {
        $request->validate([
            'member' => 'required',
            'total_pay' => 'required',
        ], [
            'total_pay.required' => 'Jumlah pembayaran harus diisi!',
        ]);

        $custStatus = 0;
        $checkCust = Customer::where('no_hp', $request['no_hp'])->first();
        if ($request->member == "Member") {
            $poin = $request->total * 0.01;
            if (!$checkCust) {
                $custStatus = 1;
                $createCustomer = Customer::create([
                    'no_hp' => $request->no_hp,
                    'poin' => $poin
                ]);
                $customerId = $createCustomer->id;
            } else {
                $checkCust->update(['poin' => $checkCust['poin'] + $poin]);
                $customerId = $checkCust['id'];
            }
        }

        $pay = str_ireplace(array('Rp.', '.', ' '), '', $request->total_pay);
        $createSale = Sale::create([
            'total_price' => $request->total,
            'total_pay' => $pay,
            'total_return' => (int)$pay - (int)$request->total,
            'customer_id' => $customerId ?? NULL,
            'user_id' => Auth::user()->id,
        ]);

        foreach ($request->shop as $item) {
            $createDetailSale = DetailSale::create([
                'sale_id' => $createSale->id,
                'product_id' => explode(";", $item)[0],
                'amount' => explode(";", $item)[3],
                'sub_total' => explode(";", $item)[4],
            ]);
            $product = Product::find(explode(";", $item)[0]);
            $updateStock = $product->update([
                'stock' => $product->stock - explode(";", $item)[3],
            ]);
        }

        if ($createSale) {
            if ($custStatus || $checkCust) {
                return redirect()->route('sale.create_member', $createSale['id']);
            } else {
                return redirect()->route('sale.show.print', $createSale['id']);
            }
        } else {
            return redirect()->route('sale.create')->with('error', 'Gagal Menambah Penjualan!');
        }
    }

    public function showPrint($id)
    {
        $sale = Sale::find($id);
        $ket = 'show';
        $title = 'Pembayaran';
        $page = 'sale';
        return view('dashboard.admin.orders.print', compact('sale', 'ket', 'title', 'page'));
    }

    public function print($id)
    {
        $sale = [];
        $sale = Sale::where('id', $id)->with('customer', 'detailSale', 'user')->first()->toArray();
        $sale['detailSale'] = DetailSale::where('sale_id', $sale['id'])->with('product')->get()->toArray();

        view()->share('sale', $sale);

        $pdf = Pdf::loadView('dashboard.admin.orders.unduh', $sale);

        return $pdf->download('receipt.pdf');
    }

    public function export()
    {
        $fileName = 'laporan' . '.xlsx';

        return Excel::download(new SaleExport, $fileName);
    }
}
