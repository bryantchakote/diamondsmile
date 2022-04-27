<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->index();
            $table->char('sexe');
            $table->date('date_nais');
            $table->string('lieu_nais')->nullable();
            $table->string('adresse')->nullable();
            $table->string('tel')->nullable();
            $table->string('email')->nullable();
            $table->string('profession')->nullable();
            $table->string('referant')->nullable();
            $table->string('tel_referant')->nullable();
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
        Schema::dropIfExists('patients');
    }
}
