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
            // Campos específicos do Promob
            $table->string('categoria')->nullable()->after('atualizado_por');
            $table->string('subcategoria')->nullable()->after('categoria');
            $table->string('referencia')->nullable()->after('subcategoria');
            $table->string('familia')->nullable()->after('referencia');
            $table->string('grupo')->nullable()->after('familia');
            $table->decimal('largura', 8, 2)->nullable()->after('grupo');
            $table->decimal('altura', 8, 2)->nullable()->after('largura');
            $table->decimal('profundidade', 8, 2)->nullable()->after('altura');
            $table->string('dimensoes_texto')->nullable()->after('profundidade');
            $table->string('guid')->nullable()->after('dimensoes_texto');
            $table->integer('repeticao')->default(1)->after('guid');
            $table->timestamp('data_importacao_xml')->nullable()->after('repeticao');
            
            // Índices para performance
            $table->index('categoria');
            $table->index('familia');
            $table->index('guid');
            $table->index('data_importacao_xml');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('itens_projeto', function (Blueprint $table) {
            $table->dropIndex(['categoria']);
            $table->dropIndex(['familia']);
            $table->dropIndex(['guid']);
            $table->dropIndex(['data_importacao_xml']);
            
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
