<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('joueurs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom', 30);
            $table->string('prenom', 50);
            $table->string('genre', 5);
            $table->string('adresse', 80);
            $table->integer('cp');
            $table->string('ville', 30);
            $table->string('telephone', 15);
            $table->date('dateNaissance');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('joueurs');
    }
};
