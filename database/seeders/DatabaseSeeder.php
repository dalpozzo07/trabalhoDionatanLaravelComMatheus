<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@email.com',
            'password' => Hash::make('12345A'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Gerente',
            'email' => 'gerente@email.com',
            'password' => Hash::make('12345G'),
            'role' => 'gerente',
        ]);

        User::create([
            'name' => 'Cliente',
            'email' => 'cliente@email.com',
            'password' => Hash::make('12345C'),
            'role' => 'cliente',
        ]);

        $this->call(ProductSeeder::class);
    }
}
