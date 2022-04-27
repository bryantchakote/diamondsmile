<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cons');
            $table->unsignedBigInteger('id_trait');
            $table->string('dents')->nullable();
            $table->string('desc')->nullable();
            $table->string('duree')->nullable();
            $table->mediumInteger('prix');
            $table->boolean('confirme');
            $table->boolean('termine');
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
        Schema::dropIfExists('plans');
    }
}
