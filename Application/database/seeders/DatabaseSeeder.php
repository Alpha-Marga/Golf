<?php

namespace Database\Seeders;

use App\Models\Joueur;
use Illuminate\Database\Seeder;
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
        // \App\Models\User::factory(10)->create();

        User::create([
            'id' => 1,
            'name' => 'Balde',
            'email' => 'alphabalde0102@gmail.com',
            'password' => Hash::make('Qalf.0920')

        ]);

    }
}
