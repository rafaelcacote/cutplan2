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
        Schema::create('materiais_item_projeto', function (Blueprint $table) {
            $table->id();
            
            // Relacionamento com item do projeto
            $table->foreignId('item_projeto_id')->constrained('itens_projeto')->onDelete('cascade');
            
            // Dados do material importado do XML Promob
            $table->string('id_promob')->nullable(); // ID do item no XML
            $table->string('descricao'); // Descrição do material
            $table->string('referencia')->nullable(); // Referência/código
            $table->string('unidade')->nullable(); // Unidade (UN, M, M2, etc)
            $table->decimal('quantidade', 10, 4)->default(0); // Quantidade necessária
            $table->integer('repeticao')->default(1); // Repetição no projeto
            
            // Dimensões
            $table->decimal('largura', 8, 2)->nullable();
            $table->decimal('altura', 8, 2)->nullable();
            $table->decimal('profundidade', 8, 2)->nullable();
            $table->string('dimensoes_texto')->nullable(); // Texto das dimensões como vem do XML
            
            // Classificação
            $table->string('categoria')->nullable();
            $table->string('subcategoria')->nullable();
            $table->string('familia')->nullable();
            $table->string('grupo')->nullable();
            
            // Dados técnicos do Promob
            $table->string('guid')->nullable(); // GUID único do Promob
            $table->string('unique_id')->nullable(); // UNIQUEID do XML
            $table->string('component')->nullable(); // Se é componente (Y/N)
            $table->string('structure')->nullable(); // Se é estrutura (Y/N)
            $table->text('observacoes')->nullable();
            
            // Dados do XML original
            $table->text('xml_data')->nullable(); // Dados completos do XML para referência
            $table->json('metadados')->nullable(); // Metadados estruturados
            
            // Controle de importação
            $table->string('arquivo_xml_nome')->nullable(); // Nome do arquivo importado
            $table->timestamp('data_importacao')->nullable();
            $table->foreignId('importado_por')->nullable()->constrained('users');
            
            $table->timestamps();
            
            // Índices para performance
            $table->index(['item_projeto_id', 'categoria']);
            $table->index('guid');
            $table->index('referencia');
            $table->index('data_importacao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materiais_item_projeto');
    }
};
