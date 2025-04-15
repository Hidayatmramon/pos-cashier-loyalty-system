<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Sale;
use App\Models\Product;
use App\Models\DetailSale;
use Carbon\Carbon;


class PageController extends Controller
{

    //backend
    public function Dashboard()
    {

        if (Auth::user()->role === 'admin') {
            $salesData = Sale::selectRaw("DATE(created_at) as date, COUNT(*) as total_sales")
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            $labels = $salesData->pluck('date')->map(function ($date) {
                return Carbon::parse($date)->format('d F Y'); 
            });

            $data = $salesData->pluck('total_sales'); 

            $detailSales = DetailSale::with('product')->get();

            $totalSales = $detailSales->count();

            $productCounts = $detailSales->groupBy('product_id')->map(function ($group) {
                return $group->count();
            });
            $dataProducts = [];
            foreach ($productCounts as $key => $value) {
                array_push($dataProducts, $value);
            }

            $labelProducts = Product::whereIn('id', $productCounts->keys())->pluck('name');

            return view('dashboard.admin.dashboard.index', compact('labels', 'labelProducts', 'data', 'dataProducts'));
        }else{
            $sales = Sale::whereDate('created_at', Carbon::today())->count();
            return view('dashboard.cashier.index', compact('sales'));
        }
    }

}
