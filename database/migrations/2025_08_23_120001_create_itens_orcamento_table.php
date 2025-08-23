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
        Schema::create('itens_orcamento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orcamento_id')->constrained('orcamentos')->name('fk_item_orc_orc');
            $table->string('descricao', 255);
            $table->decimal('quantidade', 18, 4);
            $table->foreignId('unidade_id')->nullable()->constrained('unidades')->name('fk_item_orc_unid');
            $table->decimal('preco_unitario', 14, 4);
            $table->decimal('total', 14, 4);
            $table->foreignId('item_servico_id')->nullable()->constrained('itens_servico')->name('fk_item_servico');
            $table->timestamps();
            
            $table->index('orcamento_id', 'fk_item_orc_orc_idx');
            $table->index('unidade_id', 'fk_item_orc_unid_idx');
            $table->index('item_servico_id', 'fk_item_servico_item_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itens_orcamento');
    }
};
