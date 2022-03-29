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
        Schema::create('dates', function (Blueprint $table) {
            $table->integer('jour');
            $table->integer('tournoiId');
            $table->unsignedInteger('saisonId');
            $table->date('date');

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

            $table->primary(['jour','tournoiId','saisonId']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dates');
    }
};
