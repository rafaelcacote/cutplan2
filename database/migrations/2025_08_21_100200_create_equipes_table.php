<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome', 100);
            $table->text('descricao')->nullable();
            $table->unsignedBigInteger('lider_id');
            $table->boolean('ativo')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('lider_id')->references('id')->on('membros');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipes');
    }
};
