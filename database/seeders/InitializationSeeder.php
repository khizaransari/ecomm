<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InitializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = array(
            [ 'first_name' => 'Super', 'last_name' => 'Admin', 'email' => 'admin@example.com','password' => Hash::make('12345678'), 'type' => 0],
            [ 'first_name' => 'John Doe 1', 'last_name' => 'John Doe', 'email' => 'john1@example.com','password' => Hash::make('12345678'), 'type' => 1],
            [ 'first_name' => 'John Doe 2', 'last_name' => 'John Doe', 'email' => 'john2@example.com','password' => Hash::make('12345678'), 'type' => 1],
            [ 'first_name' => 'John Doe 3', 'last_name' => 'John Doe', 'email' => 'john3@example.com','password' => Hash::make('12345678'), 'type' => 1],
        );
        User::insert($users);
    }
}
