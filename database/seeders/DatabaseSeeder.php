<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);

        $user = User::factory()->create([
            'name' => 'User',
            'email' => 'user@example.com',
        ]);
        
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleUser = Role::create(['name' => 'user']);

        $permissionMaster = Permission::create(['name' => 'access room']);
        $permissionReport = Permission::create(['name' => 'access report']);
        $permissionTransaction = Permission::create(['name' => 'access reservation']);

        $roleAdmin->givePermissionTo($permissionMaster);
        $roleAdmin->givePermissionTo($permissionReport);
        $roleUser->givePermissionTo($permissionTransaction);
        
        $admin->assignRole($roleAdmin);
        $user->assignRole($roleUser);

        Product::create([
            'ProductName' => 'Minuman Soda',
            'Price' => '20000',
        ]);
        Product::create([
            'ProductName' => 'Air Putih',
            'Price' => '15000',
        ]);
        Product::create([
            'ProductName' => 'Jasa Laundry',
            'Price' => '100000',
        ]);
        Product::create([
            'ProductName' => 'Snack',
            'Price' => '25000',
        ]);


    }
}
