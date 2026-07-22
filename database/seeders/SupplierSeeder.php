<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            [
                'code' => 'SUP-001',
                'name' => 'PT Indologistic Vendor Utama',
                'email' => 'contact@indologistic.co.id',
                'phone' => '021-5551234',
                'address' => 'Kawasan Industri Pulogadung Blok B No. 12, Jakarta Timur'
            ],
            [
                'code' => 'SUP-002',
                'name' => 'CV Terang Abadi Sentosa',
                'email' => 'sales@terangabadi.com',
                'phone' => '031-8889990',
                'address' => 'Jl. Industri Raya No. 45, Surabaya'
            ],
            [
                'code' => 'SUP-003',
                'name' => 'PT Mitra Jaya Komponen',
                'email' => 'info@mitrajaya.com',
                'phone' => '022-7776655',
                'address' => 'Jl. Soekarno Hatta No. 102, Bandung'
            ],
        ];

        foreach ($suppliers as $sup) {
            Supplier::updateOrCreate(['code' => $sup['code']], $sup);
        }
    }
}
