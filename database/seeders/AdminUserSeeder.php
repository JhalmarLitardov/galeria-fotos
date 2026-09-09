<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@galeria.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('20260123') // Contraseña inicial
            ]
        );
    }
}
