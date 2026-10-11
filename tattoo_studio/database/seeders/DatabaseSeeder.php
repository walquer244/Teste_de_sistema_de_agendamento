<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::firstOrCreate(
            ['email' => 'admin@inkstudio.com'],
            [
                'name'     => 'Administrador Ink Studio',
                'password' => Hash::make('password'),
            ]
        );

        // Core business seeders
        $this->call([
            FuncionarioSeeder::class,
            AgendamentoSeeder::class,
            GaleriaSeeder::class,
        ]);
    }
}
