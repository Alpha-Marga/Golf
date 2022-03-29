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
        Schema::create('trous', function (Blueprint $table) {
            $table->integer('idTrou');
            $table->string('couleur', 20);
            $table->unsignedInteger('parcoursId');
            $table->string('genreJoueur');
            $table->integer('par');
            $table->integer('distanceMetre');
            $table->char('uniteMetre', 1);
            $table->integer('distanceYard');
            $table->char('uniteYard', 1);

            $table->foreign('parcoursId')
            ->references('idParcours')
            ->on('parcours')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->primary(['idTrou','parcoursId','couleur']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trous');
    }
};
