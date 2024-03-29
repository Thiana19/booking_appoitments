<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert a user
        DB::table('users')->insert([
            'username' => 'admin',
            'password' => Hash::make('admin@123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
