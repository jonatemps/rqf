<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateVueServiceGourmandAnnee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()

    {

        DB::statement("CREATE VIEW vue_service_gourmand_annee AS SELECT SUM(d.montant) somme, s.name service,COUNT(d.id) nombre FROM demandes d JOIN users u ON d.user_id = u.id  JOIN services s ON u.service_id=s.id WHERE YEAR(d.created_at)=YEAR(NOW()) GROUP BY service ORDER BY somme DESC LIMIT 5");

    }



    public function down()

    {

        DB::statement("DROP VIEW vue_service_gourmand_annee");

    }
}
