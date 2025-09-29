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
        Schema::create('materiais_itens_projeto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_projeto_id');
            $table->unsignedBigInteger('material_id')->nullable(); // Se for manual ou match com material cadastrado
            $table->string('codigo_promob')->nullable(); // Código do Promob, se importado
            $table->string('descricao');
            $table->string('unidade')->nullable();
            $table->decimal('quantidade', 12, 4);
            $table->decimal('largura', 12, 2)->nullable();
            $table->decimal('altura', 12, 2)->nullable();
            $table->decimal('profundidade', 12, 2)->nullable();
            $table->string('familia')->nullable();
            $table->string('grupo')->nullable();
            $table->string('imagem')->nullable();
            $table->enum('origem', ['manual', 'importacao'])->default('manual');
            $table->timestamps();

            $table->foreign('item_projeto_id')->references('id')->on('itens_projeto')->onDelete('cascade');
            $table->foreign('material_id')->references('id')->on('materiais')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materiais_itens_projeto');
    }
};