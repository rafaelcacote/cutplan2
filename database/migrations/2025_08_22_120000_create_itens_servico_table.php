<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('itens_servico', function (Blueprint $table) {
            $table->id();
            $table->text('descricao_item');
            $table->unsignedBigInteger('servico_id');
            $table->timestamps();

            $table->index('servico_id', 'fk_itens_srevico_servico_idx');
            $table->foreign('servico_id', 'fk_itens_srevico_servico')
                ->references('id')->on('servicos');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('itens_servico');
    }
};
