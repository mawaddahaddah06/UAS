<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['code' => 'CAT-ELC', 'name' => 'Elektronik & Gadget', 'description' => 'Peralatan elektronik dan perangkat digital'],
            ['code' => 'CAT-RAW', 'name' => 'Bahan Baku', 'description' => 'Material dan bahan mentah komponen produksi'],
            ['code' => 'CAT-ATK', 'name' => 'Alat Tulis Kantor', 'description' => 'Perlengkapan operasional kantor dan administrasi'],
            ['code' => 'CAT-PRT', 'name' => 'Suku Cadang & Sparepart', 'description' => 'Komponen mesin dan suku cadang perawatan'],
            ['code' => 'CAT-PKG', 'name' => 'Kemasan & Packaging', 'description' => 'Kardus, plastik bubble, dan material pembungkus'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['code' => $cat['code']], $cat);
        }
    }
}
