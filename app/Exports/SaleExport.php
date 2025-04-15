<?php

namespace App\Exports;

use App\Models\Sale;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SaleExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Sale::with('detailSale', 'customer', 'user', 'detailSale.product')->get();
    }

    public function headings(): array
    {
        return [
            "Nama Pelanggan", "No HP Pelanggan", "Poin Pelanggan", "Produk", "Total Harga", "Total Bayar", "Total Diskon Poin", "Total Kembalian", "Tanggal Pembelian"
        ];
    }

    public function map($item): array
    {
        $products = '';
        foreach ($item->detailSale as $key => $value) {
            $products .= $value['product']['name'] . " ( " . $value['amount'] . " : Rp. " . number_format($value['sub_total'], 0, ',', '.') . " )" . " , ";
        }
        return [
            $item->customer ? $item->customer->name : 'Bukan Member',
            $item->customer ? $item->customer->no_hp : 'Bukan Member',
            $item->customer ? $item->customer->poin : 'Bukan Member',
            $products,
            "Rp. " . number_format($item->total_price, 0, ',', '.'),
            "Rp. " . number_format($item->total_pay, 0, ',', '.'),
            "Rp. " . number_format($item->total_poin, 0, ',', '.'),
            "Rp. " . number_format($item->total_return, 0, ',', '.'),
            $item->created_at
        ];
    }
}
