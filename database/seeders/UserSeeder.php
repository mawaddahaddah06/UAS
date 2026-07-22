<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Tamus Tahir',
                'email' => 'tamus@gmail.com',
                'role' => 'Superadmin',
                'phone' => '081234567890',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'manager@gmail.com',
                'role' => 'Warehouse Manager',
                'phone' => '081234567891',
            ],
            [
                'name' => 'Siti Rahma',
                'email' => 'staff@gmail.com',
                'role' => 'Staff Gudang',
                'phone' => '081234567892',
            ],
            [
                'name' => 'Ahmad Hidayat',
                'email' => 'auditor@gmail.com',
                'role' => 'Auditor',
                'phone' => '081234567893',
            ],
        ];

        foreach ($users as $user) {
            if (User::where('email', $user['email'])->exists()) {
                continue;
            }

            User::factory()->create([
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role'],
                'phone' => $user['phone'] ?? null,
            ]);
        }
    }
}
