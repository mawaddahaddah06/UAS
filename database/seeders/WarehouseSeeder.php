<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        $warehouses = [
            [
                'code' => 'WH-MAIN',
                'name' => 'Gudang Utama A',
                'address' => 'Gedung Pusat Logistik Lt. 1, Jakarta',
                'manager_name' => 'Budi Santoso'
            ],
            [
                'code' => 'WH-TRANSIT',
                'name' => 'Gudang Transit B',
                'address' => 'Kawasan Pergudangan Bandara Soekarno Hatta',
                'manager_name' => 'Siti Rahma'
            ],
            [
                'code' => 'WH-STORAGE-C1',
                'name' => 'Rak Storage Area C1',
                'address' => 'Gedung Tambahan Sayap Barat, Jakarta',
                'manager_name' => 'Ahmad Hidayat'
            ],
        ];

        foreach ($warehouses as $wh) {
            Warehouse::updateOrCreate(['code' => $wh['code']], $wh);
        }
    }
}
