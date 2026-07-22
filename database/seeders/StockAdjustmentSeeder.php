<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\StockAdjustment;
use App\Models\User;
use Illuminate\Database\Seeder;

class StockAdjustmentSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $manager = User::where('role', 'Warehouse Manager')->first() ?? $user;
        $product1 = Product::first();
        $product2 = Product::skip(1)->first();

        if (!$user || !$product1) {
            return;
        }

        // Approved Adjustment
        $sysQty1 = $product1->stock_quantity;
        $actQty1 = $sysQty1 - 2; // Selisih 2 pcs hilang/rusak
        $adj1 = StockAdjustment::create([
            'adjustment_code' => 'ADJ-20260722-0001',
            'product_id' => $product1->id,
            'warehouse_id' => $product1->warehouse_id,
            'user_id' => $user->id,
            'approved_by_user_id' => $manager->id,
            'system_quantity' => $sysQty1,
            'actual_quantity' => $actQty1,
            'difference' => -2,
            'type' => 'SUBTRACTION',
            'reason' => 'Barang Rusak Kemasan saat pemindahan rak gudang',
            'status' => 'APPROVED',
        ]);
        $product1->update(['stock_quantity' => $actQty1]);

        // Pending Adjustment
        if ($product2) {
            $sysQty2 = $product2->stock_quantity;
            $actQty2 = $sysQty2 + 5; // Ditemukan lebih
            StockAdjustment::create([
                'adjustment_code' => 'ADJ-20260722-0002',
                'product_id' => $product2->id,
                'warehouse_id' => $product2->warehouse_id,
                'user_id' => $user->id,
                'approved_by_user_id' => null,
                'system_quantity' => $sysQty2,
                'actual_quantity' => $actQty2,
                'difference' => 5,
                'type' => 'ADDITION',
                'reason' => 'Kelebihan jumlah fisik saat opname bulanan',
                'status' => 'PENDING',
            ]);
        }
    }
}
