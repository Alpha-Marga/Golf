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
        Schema::create('coups', function (Blueprint $table) {
            $table->engine='MyISAM';
            $table->unsignedInteger('joueurId');
            $table->unsignedInteger('parcoursId');
            $table->unsignedInteger('trouId');
            
            $table->string('couleur', 20);
            $table->integer('tournoiId');
            $table->unsignedInteger('saisonId');
            $table->integer('jour');
            $table->integer('nombreCoups');

            $table->foreign('joueurId')
            ->references('id')
            ->on('joueurs')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('parcoursId')
            ->references('parcoursId')
            ->on('trous')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('trouId')
            ->references('idTrou')
            ->on('trous')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('couleur')
            ->references('couleur')
            ->on('trous')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('tournoiId')
            ->references('tournoiId')
            ->on('dates')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('saisonId')
            ->references('saisonId')
            ->on('dates')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('jour')
            ->references('jour')
            ->on('dates')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->primary(['joueurId','trouId','couleur','parcoursId','tournoiId','saisonId','jour'], 'realiser_pk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coups');
    }
};
