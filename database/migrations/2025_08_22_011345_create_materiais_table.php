<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('materiais', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 150);
            $table->unsignedBigInteger('tipo_id');
            $table->unsignedBigInteger('unidade_id');
            $table->decimal('preco_custo', 12, 4)->nullable();
            $table->decimal('estoque_minimo', 16, 4)->nullable();
            $table->boolean('controla_estoque')->default(true);
            $table->boolean('ativo')->default(true);
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('tipo_id', 'fk_materiais_tipo')->references('id')->on('tipos_materiais');
            $table->foreign('unidade_id', 'fk_materiais_unidade')->references('id')->on('unidades');
            $table->foreign('user_id', 'fk_materiais_user')->references('id')->on('users');

            // Indexes
            $table->index('tipo_id', 'fk_materiais_tipo');
            $table->index('unidade_id', 'fk_materiais_unidade');
            $table->index('user_id', 'fk_materiais_user_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materiais');
    }
};
