<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\StockInDetail;
use App\Models\StockInHeader;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;

class StockInSeeder extends Seeder
{
    public function run(): void
    {
        $supplier = Supplier::first();
        $user = User::first();
        $products = Product::take(3)->get();

        if (!$supplier || !$user || $products->isEmpty()) {
            return;
        }

        $header = StockInHeader::create([
            'transaction_code' => 'TRX-IN-20260722-0001',
            'transaction_date' => now()->format('Y-m-d'),
            'supplier_id' => $supplier->id,
            'user_id' => $user->id,
            'total_amount' => 0,
            'notes' => 'Penerimaan pasokan barang rutin bulanan dari vendor utama.',
        ]);

        $total = 0;
        foreach ($products as $product) {
            $qty = 10;
            $price = $product->purchase_price > 0 ? $product->purchase_price : 50000;
            $subtotal = $qty * $price;
            $total += $subtotal;

            StockInDetail::create([
                'stock_in_header_id' => $header->id,
                'product_id' => $product->id,
                'quantity' => $qty,
                'unit_price' => $price,
                'subtotal' => $subtotal,
            ]);

            $product->increment('stock_quantity', $qty);
        }

        $header->update(['total_amount' => $total]);
    }
}
