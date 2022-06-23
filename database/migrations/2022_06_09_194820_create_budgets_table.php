<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_depense');
            $table->unsignedBigInteger('id_annee');
            $table->unsignedBigInteger('prevision');
            $table->unsignedBigInteger('realisation')->nullable();
            $table->timestamps();

            $table->foreign('id_depense')->references('id')->on('depenses')->onDelete('cascade');
            $table->foreign('id_annee')->references('id')->on('annees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('budgets');
    }
}
