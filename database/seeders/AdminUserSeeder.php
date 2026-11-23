<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        Admin::updateOrCreate(
            ['email' => 'admin@starcake.com'],
            [
                'name' => 'Star Cake Admin',
                'password' => Hash::make('admin123'),
                'role' => 'superadmin',
                'is_active' => true,
            ]
        );
    }
}
