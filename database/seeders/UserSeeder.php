<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\RoleType;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $superadmin = User::create([
        //     'name' => 'Super Admin',
        //     'email' => 'superadmin@gmail.com',
        //     'status' => 'Active',
        //     'department' => 'IT',
        //     'password' => Hash::make('password'),
        //     'remember_token' => Str::random(10),
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
        // $superadmin->assignRole(RoleType::SUPERADMIN);

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'oke@gmail.com',
            'status' => 'Active',
            'department' => 'IT',
            'password' => Hash::make('@hi123'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $admin->assignRole(RoleType::ADMIN);

        // $operator = User::create([
        //     'name' => 'Operator',
        //     'email' => 'operator@gmail.com',
        //     'status' => 'Active',
        //     'department' => 'IT',
        //     'password' => Hash::make('password'),
        //     'remember_token' => Str::random(10),
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
        // $operator->assignRole(RoleType::OPERATOR);

        // $viewer = User::create([
        //     'name' => 'Viewer',
        //     'email' => 'viewer@gmail.com',
        //     'status' => 'Active',
        //     'department' => 'IT',
        //     'password' => Hash::make('password'),
        //     'remember_token' => Str::random(10),
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
        // $viewer->assignRole(RoleType::VIEWER);
    }
}