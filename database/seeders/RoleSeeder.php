<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {

        Role::firstOrCreate(['id' => 1], ['name' => 'Admin']);
        Role::firstOrCreate(['id' => 2], ['name' => 'Vendedor']);
        Role::firstOrCreate(['id' => 3], ['name' => 'Comprador']);
    }
}