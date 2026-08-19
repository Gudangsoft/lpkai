<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Create admin user (skip if already exists)
        if (! User::where('email', 'admin@lppsp.org')->exists()) {
            User::create([
                'name'     => 'Admin LPPSP',
                'email'    => 'admin@lppsp.org',
                'password' => Hash::make('lppsp2024'),
            ]);
        }

        // Seed all content
        $this->call([
            ProfileSeeder::class,
            LayananSeeder::class,
            PengalamanSeeder::class,
            KlienMitraSeeder::class,
            TestimoniSeeder::class,
            PublikasiSeeder::class,
            BeritaSeeder::class,
        ]);
    }
}
