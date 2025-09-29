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
        Schema::create('itens_projeto', function (Blueprint $table) {
            $table->id();
            
            // Relacionamentos principais
            $table->foreignId('projeto_id')->constrained('projetos')->onDelete('cascade');
            $table->foreignId('item_orcamento_id')->nullable()->constrained('itens_orcamento')->onDelete('set null');
            
            // Dados do item (copiados do orçamento, mas podem ser alterados)
            $table->string('descricao');
            $table->text('observacao')->nullable();
            $table->decimal('quantidade', 10, 3);
            $table->foreignId('unidade_id')->nullable()->constrained('unidades')->onDelete('set null');
            
            // Preços e custos
            $table->decimal('preco_orcado', 10, 4); // Preço original do orçamento
            $table->decimal('preco_real', 10, 4)->nullable(); // Custo real após execução
            $table->decimal('custo_materiais', 10, 4)->default(0); // Soma dos materiais utilizados
            $table->decimal('custo_mao_obra', 10, 4)->default(0); // Custo de mão de obra
            
            // Status e controle
            $table->enum('status', ['pendente', 'em_andamento', 'concluido', 'cancelado'])->default('pendente');
            $table->date('data_inicio_prevista')->nullable();
            $table->date('data_inicio_real')->nullable();
            $table->date('data_conclusao_prevista')->nullable();
            $table->date('data_conclusao_real')->nullable();
            
            // Controle de progresso
            $table->decimal('percentual_concluido', 5, 2)->default(0);
            
            // Integração com Promob
            $table->string('codigo_promob')->nullable(); // Código do item no Promob
            $table->text('dados_promob_xml')->nullable(); // XML completo do Promob (para histórico)
            $table->json('metadados_promob')->nullable(); // Dados estruturados do Promob
            
            // Auditoria
            $table->foreignId('criado_por')->constrained('users');
            $table->foreignId('atualizado_por')->nullable()->constrained('users');
            
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index(['projeto_id', 'status']);
            $table->index('codigo_promob');
            $table->index('data_conclusao_prevista');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itens_projeto');
    }
};