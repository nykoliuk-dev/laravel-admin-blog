<?php

namespace Database\Seeders;

use App\Enums\RoleSlug;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::query()->where('slug', RoleSlug::ADMIN->value)->firstOrFail();

        $adminUser = User::query()->create([
            'name' => 'Admin User',
            'email' => 'admin@laravelblog.loc',
            'password' => Hash::make('password'),
        ]);

        $adminUser->roles()->attach($adminRole);
    }
}
