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
        Schema::table('itens_projeto', function (Blueprint $table) {
            // Campos de categorização do Promob
            $table->string('categoria', 100)->nullable()->after('codigo_promob');
            $table->string('subcategoria', 100)->nullable()->after('categoria');
            $table->string('referencia', 50)->nullable()->after('subcategoria');
            $table->string('familia', 100)->nullable()->after('referencia');
            $table->string('grupo', 100)->nullable()->after('familia');
            
            // Dimensões físicas
            $table->decimal('largura', 10, 2)->nullable()->after('grupo');
            $table->decimal('altura', 10, 2)->nullable()->after('largura');
            $table->decimal('profundidade', 10, 2)->nullable()->after('altura');
            $table->string('dimensoes_texto', 100)->nullable()->after('profundidade');
            
            // Controle Promob
            $table->string('guid', 50)->nullable()->after('dimensoes_texto')->index();
            $table->integer('repeticao')->default(1)->after('guid');
            $table->timestamp('data_importacao_xml')->nullable()->after('repeticao');
            
            // Índices para melhor performance
            $table->index(['categoria', 'subcategoria']);
            $table->index('referencia');
            $table->index('familia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('itens_projeto', function (Blueprint $table) {
            $table->dropIndex(['categoria', 'subcategoria']);
            $table->dropIndex(['referencia']);
            $table->dropIndex(['familia']);
            $table->dropIndex(['guid']);
            
            $table->dropColumn([
                'categoria',
                'subcategoria', 
                'referencia',
                'familia',
                'grupo',
                'largura',
                'altura',
                'profundidade',
                'dimensoes_texto',
                'guid',
                'repeticao',
                'data_importacao_xml'
            ]);
        });
    }
};
