<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Roles;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rolesAdmin = Roles::where('name', 'admin')->first();

        User::create(
            [
                   'name' => 'user',
                   'email' => 'admin@email.com',
                   'role_id' => $rolesAdmin->id,
                   'password' => Hash::make('password'),
            ]
        );
    }
}
