<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create one store
        $store = Store::create([
            'name' => 'Fashion Avenue',
        ]);

        // Create an admin user
        User::create([
            'name' => 'Admin User', // Set a name for the admin user
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin', // Set the role as 'admin'
            'store_id' => $store->id, // Associate the store with the admin user
        ]);

        // Create a regular user
        User::create([
            'name' => 'Regular User', // Set a name for the regular user
            'email' => 'user@fa.com',
            'password' => Hash::make('12345678'),
            'role' => 'user', // Set the role as 'user'
            'store_id' => $store->id, // Associate the store with the regular user
        ]);
    }
}
