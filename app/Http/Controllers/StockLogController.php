<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockLog;
use Illuminate\Http\Request;

class StockLogController extends Controller
{
    public function index(Request $request)
    {
        $query = StockLog::with(['product', 'user']);

        if ($request->has('product_id') && $request->product_id != '') {
            $query->where('product_id', $request->product_id);
        }

        return view('stock_log.index', [
            'title' => 'Kartu Stok & Audit Log Mutasi',
            'logs' => $query->latest('id')->get(),
            'products' => Product::all(),
            'selectedProductId' => $request->product_id ?? '',
        ]);
    }
}
