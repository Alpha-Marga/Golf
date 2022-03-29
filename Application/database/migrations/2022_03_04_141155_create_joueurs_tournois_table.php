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
        Schema::create('joueurs_tournois', function (Blueprint $table) {
            $table->unsignedInteger('joueurId');
            $table->integer('tournoiId');
            $table->unsignedInteger('saisonId');
            $table->boolean('tournoiGagne');

            $table->foreign('joueurId')
            ->references('id')
            ->on('joueurs')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('tournoiId')
            ->references('idTournoi')
            ->on('tournois')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('saisonId')
            ->references('saisonId')
            ->on('tournois')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->primary(['joueurId','tournoiId','saisonId']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('joueurs_tournois');
    }
};
