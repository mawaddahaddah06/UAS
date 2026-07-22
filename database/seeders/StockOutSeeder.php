<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\StockOutDetail;
use App\Models\StockOutHeader;
use App\Models\User;
use Illuminate\Database\Seeder;

class StockOutSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $products = Product::where('stock_quantity', '>', 5)->take(2)->get();

        if (!$user || $products->isEmpty()) {
            return;
        }

        $header = StockOutHeader::create([
            'transaction_code' => 'TRX-OUT-20260722-0001',
            'transaction_date' => now()->format('Y-m-d'),
            'recipient_department' => 'Divisi Operasional & Produksi',
            'user_id' => $user->id,
            'total_amount' => 0,
            'notes' => 'Pengeluaran alat tulis dan perlengkapan kerja tim.',
        ]);

        $total = 0;
        foreach ($products as $product) {
            $qty = 2;
            $price = $product->selling_price > 0 ? $product->selling_price : 75000;
            $subtotal = $qty * $price;
            $total += $subtotal;

            StockOutDetail::create([
                'stock_out_header_id' => $header->id,
                'product_id' => $product->id,
                'quantity' => $qty,
                'unit_price' => $price,
                'subtotal' => $subtotal,
            ]);

            $product->decrement('stock_quantity', $qty);
        }

        $header->update(['total_amount' => $total]);
    }
}
