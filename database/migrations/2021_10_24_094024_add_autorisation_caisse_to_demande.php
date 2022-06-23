<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAutorisationCaisseToDemande extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('demandes', function (Blueprint $table) {
            $table->boolean('autorisationCaisse')->after('autorisationRec')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('demandes', function (Blueprint $table) {
            //
        });
    }
}
