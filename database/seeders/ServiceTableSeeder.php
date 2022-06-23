<?php

namespace Database\Seeders;

use App\Models\service;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('fr_FR');

        service::create([
            'name'=> 'Informatique',
            'sigle'=>'I'
        ]);

        service::create([
            'name'=> 'Ressources humaines',
            'sigle'=>'R.H'
        ]);

        service::create([
            'name'=> 'Entraintien',
            'sigle'=>'Ent'
        ]);

        service::create([
            'name'=> 'Transport',
            'sigle'=>'Trans'
        ]);

    }
}
