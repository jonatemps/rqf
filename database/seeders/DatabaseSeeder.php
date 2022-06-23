<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(ServiceTableSeeder::class);
        // \App\Models\User::factory(4)->create();
        // $this->call(DemandeTableSeeder::class);
        $this->call(SecteurTableSeeder::class);

    }
}
