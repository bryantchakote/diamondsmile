<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contrats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_patient');
            $table->string('assurance')->nullable();
            $table->string('matricule')->nullable();
            $table->string('employeur')->nullable();
            $table->tinyInteger('taux_couvert');            
            $table->smallInteger('valeur_D');
            $table->smallInteger('valeur_SC');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contrats');
    }
}
