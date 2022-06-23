<?php

namespace Database\Seeders;

use App\Models\Demande;
use Faker\Factory;
use Illuminate\Database\Seeder;

class DemandeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('fr_FR');

       for ($i=0; $i < 20; $i++) {
            Demande::create([
                'user_id'=> rand(1,4),
                'motif'=> $faker->randomElement(array('Devis', 'Pro format', 'autres')),
                'description'=> $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
                'emission'=> $faker->randomElement(array('totalité', 'tranche','autre')),
                'transaction'=> $faker->randomElement(array('par caisse', 'par banque','cellule')),
                'autorisationAb1'=> $faker->randomElement(array(true, false)),
                'autorisationAb2'=> $faker->randomElement(array(true, false)),
                'autorisationRec'=> $faker->randomElement(array(true, false)),
            ]);
       }
    }
}
