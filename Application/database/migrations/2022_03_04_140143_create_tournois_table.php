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
        Schema::create('tournois', function (Blueprint $table) {
            $table->integer('idTournoi');
            $table->unsignedInteger('saisonId');
            $table->unsignedInteger('parcoursId');
            $table->string('nomTournoi', 50);
            $table->date('debut');
            $table->date('fin');
            $table->integer('nbParticipants');
            $table->string('categorie', 10);

            $table->foreign('saisonId')
            ->references('idSaison')
            ->on('saisons')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('parcoursId')
            ->references('idParcours')
            ->on('parcours')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->primary(['idTournoi','saisonId']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tournois');
    }
};
