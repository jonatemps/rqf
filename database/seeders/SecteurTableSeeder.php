<?php

namespace Database\Seeders;

use App\Models\Secteur;
use Illuminate\Database\Seeder;

class SecteurTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Secteur::create([
            'slug'=> 'Rectorat',
            'nom'=> 'Rectorat',
        ]);

        Secteur::create([
            'slug'=> 'SGAC',
            'nom'=> 'Secrétariat général académique',
        ]);

        Secteur::create([
            'slug'=> 'SGAR',
            'nom'=> 'Secrétaire général chargé de recherche',
        ]);

        Secteur::create([
            'slug'=> 'SGAD',
            'nom'=> 'Secrétaire général administratif',
        ]);

        Secteur::create([
            'slug'=> 'AB',
            'nom'=> 'Administration du budget',
        ]);
    }
}
