<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membros', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome', 100);
            $table->string('email', 100)->nullable();
            $table->string('telefone', 20)->nullable();
            $table->unsignedInteger('cargo_id')->nullable();
            $table->boolean('ativo')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('cargo_id')->references('id')->on('cargos');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membros');
    }
};
