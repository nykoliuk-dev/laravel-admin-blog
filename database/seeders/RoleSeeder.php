<?php

namespace Database\Seeders;

use App\Enums\RoleSlug;
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
        foreach (RoleSlug::cases() as $role){
            Role::query()->create([
                'name' => $role->label(),
                'slug' => $role->value,
            ]);
        }
    }
}
