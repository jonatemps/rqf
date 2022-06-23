<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateVueTopDemande5ans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()

    {

        DB::statement("CREATE VIEW vue_top_demande_5ans AS SELECT d.id,dep.libelle,SUBSTRING(d.created_at,1,4) annee,MONTHNAME(d.created_at) as monthname,d.montant,d.autorisationRec,d.autorisationAb1,d.autorisationAb2,u.name utilisateur,s.name service,d.created_at FROM demandes d JOIN users u ON d.user_id = u.id JOIN services s ON u.service_id=s.id JOIN depenses dep ON dep.id = d.depense_id");

    }



    public function down()

    {

        DB::statement("DROP VIEW vue_top_demande_5ans");

    }
}
