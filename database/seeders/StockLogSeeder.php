<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\StockInHeader;
use App\Models\StockLog;
use App\Models\StockOutHeader;
use App\Models\User;
use Illuminate\Database\Seeder;

class StockLogSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        if (!$user) return;

        // Populate logs for Stock In
        $stockIns = StockInHeader::with('details')->get();
        foreach ($stockIns as $in) {
            foreach ($in->details as $detail) {
                StockLog::create([
                    'product_id' => $detail->product_id,
                    'user_id' => $in->user_id,
                    'reference_number' => $in->transaction_code,
                    'type' => 'IN',
                    'quantity_before' => max(0, ($detail->product->stock_quantity ?? 10) - $detail->quantity),
                    'quantity_change' => $detail->quantity,
                    'quantity_after' => $detail->product->stock_quantity ?? 10,
                    'notes' => 'Penerimaan barang masuk seeder',
                ]);
            }
        }

        // Populate logs for Stock Out
        $stockOuts = StockOutHeader::with('details')->get();
        foreach ($stockOuts as $out) {
            foreach ($out->details as $detail) {
                StockLog::create([
                    'product_id' => $detail->product_id,
                    'user_id' => $out->user_id,
                    'reference_number' => $out->transaction_code,
                    'type' => 'OUT',
                    'quantity_before' => ($detail->product->stock_quantity ?? 10) + $detail->quantity,
                    'quantity_change' => -$detail->quantity,
                    'quantity_after' => $detail->product->stock_quantity ?? 10,
                    'notes' => 'Pengeluaran barang seeder',
                ]);
            }
        }
    }
}
