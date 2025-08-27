<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membros_equipe', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('equipe_id');
            $table->unsignedBigInteger('membro_id');
            $table->string('funcao', 50)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['equipe_id', 'membro_id'], 'uq_equipe_membro');
            $table->foreign('equipe_id')->references('id')->on('equipes');
            $table->foreign('membro_id')->references('id')->on('membros');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membros_equipe');
    }
};
