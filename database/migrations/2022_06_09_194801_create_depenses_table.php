<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cat_1');
            $table->unsignedBigInteger('id_cat_2')->nullable();
            $table->string('numero');
            $table->string('libelle');
            $table->string('sigle')->nullable();
            $table->timestamps();

            $table->foreign('id_cat_1')->references('id')->on('depenses')->onDelete('cascade');
            $table->foreign('id_cat_2')->references('id')->on('depenses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('depenses');
    }
}
