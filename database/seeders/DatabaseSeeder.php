<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // Membuat kategori awal
        \App\Models\Category::create(['nama' => 'Elektronik (HP, Laptop, dll)']);
        \App\Models\Category::create(['nama' => 'Dokumen (KTM, KTP, Buku)']);
        \App\Models\Category::create(['nama' => 'Kunci / Aksesoris']);
        \App\Models\Category::create(['nama' => 'Pakaian / Tas']);
        \App\Models\Category::create(['nama' => 'Lainnya']);

        \App\Models\User::updateOrCreate(
            ['email' => '2300018158@webmail.uad.ac.id'],
            [
                'name' => 'Admin Utama',
                'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
                'is_admin' => 1,
            ]
        );
    }
}
