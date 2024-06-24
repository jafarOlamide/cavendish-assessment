<?php

namespace Database\Seeders;

use App\Enums\RoleTypes;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::factory()->create([
            'name' => RoleTypes::ADMIN,
        ]);

        Role::factory()->create([
            'name' => RoleTypes::USER,
        ]);
    }
}
