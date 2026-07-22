<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $catElektronik = Category::where('code', 'CAT-ELC')->first()?->id ?? 1;
        $catBahanBaku   = Category::where('code', 'CAT-RAW')->first()?->id ?? 2;
        $catATK         = Category::where('code', 'CAT-ATK')->first()?->id ?? 3;
        $catSparepart   = Category::where('code', 'CAT-PRT')->first()?->id ?? 4;
        $catPackaging   = Category::where('code', 'CAT-PKG')->first()?->id ?? 5;

        $whUtama   = Warehouse::where('code', 'WH-MAIN')->first()?->id ?? 1;
        $whTransit = Warehouse::where('code', 'WH-TRANSIT')->first()?->id ?? 2;
        $whStorage = Warehouse::where('code', 'WH-STORAGE-C1')->first()?->id ?? 3;

        $products = [
            [
                'sku' => 'PRD-ELC-001',
                'name' => 'Barcode Scanner 2D Wireless',
                'category_id' => $catElektronik,
                'warehouse_id' => $whUtama,
                'unit' => 'Unit',
                'purchase_price' => 450000,
                'selling_price' => 650000,
                'stock_quantity' => 25,
                'min_stock' => 5,
                'description' => 'Scanner pemindai kode QR & Barcode berkecepatan tinggi.'
            ],
            [
                'sku' => 'PRD-ELC-002',
                'name' => 'Printer Thermal Resi 80mm',
                'category_id' => $catElektronik,
                'warehouse_id' => $whUtama,
                'unit' => 'Unit',
                'purchase_price' => 850000,
                'selling_price' => 1200000,
                'stock_quantity' => 3, // LOW STOCK ALERT
                'min_stock' => 5,
                'description' => 'Printer cetak resi dan struk pengiriman otomatis.'
            ],
            [
                'sku' => 'PRD-RAW-001',
                'name' => 'Biji Plastik Polypropylene (PP) Grade A',
                'category_id' => $catBahanBaku,
                'warehouse_id' => $whUtama,
                'unit' => 'Kg',
                'purchase_price' => 18000,
                'selling_price' => 25000,
                'stock_quantity' => 500,
                'min_stock' => 100,
                'description' => 'Bahan baku mentah plastik kualitas tinggi.'
            ],
            [
                'sku' => 'PRD-RAW-002',
                'name' => 'Cairan Pelarut Industri 20 Liter',
                'category_id' => $catBahanBaku,
                'warehouse_id' => $whTransit,
                'unit' => 'Jerigen',
                'purchase_price' => 320000,
                'selling_price' => 450000,
                'stock_quantity' => 2, // LOW STOCK ALERT
                'min_stock' => 10,
                'description' => 'Pelarut kimia khusus pembersihan mesin pabrik.'
            ],
            [
                'sku' => 'PRD-ATK-001',
                'name' => 'Kertas HVS A4 80gr Sidu (1 Dus)',
                'category_id' => $catATK,
                'warehouse_id' => $whStorage,
                'unit' => 'Dus',
                'purchase_price' => 215000,
                'selling_price' => 260000,
                'stock_quantity' => 45,
                'min_stock' => 10,
                'description' => 'Kertas cetak dokumen resmi kantor (5 rim/dus).'
            ],
            [
                'sku' => 'PRD-ATK-002',
                'name' => 'Tinta Printer Epson Original Black 664',
                'category_id' => $catATK,
                'warehouse_id' => $whStorage,
                'unit' => 'Botol',
                'purchase_price' => 75000,
                'selling_price' => 95000,
                'stock_quantity' => 4, // LOW STOCK ALERT
                'min_stock' => 15,
                'description' => 'Tinta isi ulang asli untuk printer Epson.'
            ],
            [
                'sku' => 'PRD-PRT-001',
                'name' => 'Bearing Conductor Heavy Duty 6204',
                'category_id' => $catSparepart,
                'warehouse_id' => $whTransit,
                'unit' => 'Pcs',
                'purchase_price' => 35000,
                'selling_price' => 55000,
                'stock_quantity' => 120,
                'min_stock' => 20,
                'description' => 'Sparepart bearing pemutar mesin industri.'
            ],
            [
                'sku' => 'PRD-PRT-002',
                'name' => 'V-Belt Mesin Conveyor B-52',
                'category_id' => $catSparepart,
                'warehouse_id' => $whTransit,
                'unit' => 'Pcs',
                'purchase_price' => 65000,
                'selling_price' => 90000,
                'stock_quantity' => 15,
                'min_stock' => 10,
                'description' => 'Tali sabuk karet pemutar jalur conveyor gudang.'
            ],
            [
                'sku' => 'PRD-PKG-001',
                'name' => 'Bubble Wrap Roll 1.2m x 50m',
                'category_id' => $catPackaging,
                'warehouse_id' => $whUtama,
                'unit' => 'Roll',
                'purchase_price' => 125000,
                'selling_price' => 165000,
                'stock_quantity' => 30,
                'min_stock' => 5,
                'description' => 'Plastik gelembung pelindung barang pecah belah.'
            ],
            [
                'sku' => 'PRD-PKG-002',
                'name' => 'Kardus Box Polos 30x20x15 cm',
                'category_id' => $catPackaging,
                'warehouse_id' => $whUtama,
                'unit' => 'Pcs',
                'purchase_price' => 3500,
                'selling_price' => 5500,
                'stock_quantity' => 800,
                'min_stock' => 200,
                'description' => 'Kardus standar pengiriman barang paket ekpedisi.'
            ],
        ];

        foreach ($products as $prd) {
            Product::updateOrCreate(['sku' => $prd['sku']], $prd);
        }
    }
}
