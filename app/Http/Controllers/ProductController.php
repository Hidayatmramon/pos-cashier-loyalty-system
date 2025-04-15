<?php

namespace App\Http\Controllers;

use App\Models\DetailSale;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('updated_at', 'DESC')->get();

        return view('dashboard.admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.admin.product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'img' =>  'required|mimes:jpeg,png,jpg|max:2048'
        ], [
            'name.required' => 'Nama Produk harus diisi!',
            'price.required' => 'Harga Produk harus diisi!',
            'stock.required' => 'Stok Produk harus diisi!',
            'img.required' => 'Gambar Produk harus diisi!',
            'img.mimes' => 'Jenis File tidak sesuai!',
            'img.max' => 'Ukuran file tidak boleh lebih dari 2mb!',
        ]);

        if ($request->hasFile('img')) {
            $img = $request->file('img');
            $imgName = date('YmdHis') . "." . $img->getClientOriginalExtension();
            Storage::putFileAs('public/product', $img, $imgName);
        }

        $createProduct = Product::create([
            'name' => $request->name,
            'price' => str_ireplace(array('Rp.', '.', ' '), '', $request->price),
            'stock' => $request->stock,
            'img' => $imgName,
        ]);

        if ($createProduct) {
            return redirect()->route('product.index')->with('success', 'Berhasil Menambah Data Produk!');
        } else {
            return redirect()->back()->with('error', 'Gagal Menambah Data Produk!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product, $id)
    {
        $product = Product::find($id);

        return view('dashboard.admin.product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product, $id)
    {
        $product = Product::find($id);

        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required|numeric',
        ], [
            'name.required' => 'Nama Produk harus diisi!',
            'price.required' => 'Harga Produk harus diisi!',
            'stock.required' => 'Stok Produk harus diisi!',
        ]);

        if ($request->hasFile('img')) {
            $img = $request->file('img');
            $imgName = date('YmdHis') . "." . $img->getClientOriginalExtension();
            Storage::putFileAs('public/product', $img, $imgName);
            Storage::delete('public/product/' . $product['img']);
        } else {
            $imgName = $product['img'];
        }

        $product->update([
            'name' => $request->name,
            'price' => str_ireplace(array('Rp.', '.', ' '), '', $request->price),
            'img' => $imgName,
            'stock' => $request->stock,
        ]);

        return redirect()->route('product.index')->with('success', 'Produk berhasil diperbarui!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, $id)
    {
        $detailSale = DetailSale::where('product_id', $id)->count();
        if ($detailSale) {
            return redirect()->back()->with('error', 'Produk sudah tertaut pembelian!');
        } else {
            $product = Product::find($id);
            Storage::delete('public/product/' . $product['img']);
            $deleteProduct = $product->delete();

            if ($deleteProduct) {
                return redirect()->back()->with('success', 'Berhasil Mengahapus Data Produk!');
            } else {
                return redirect()->back()->with('error', 'Gagal Mengahapus Data Produk!');
            }
        }
    }
}
