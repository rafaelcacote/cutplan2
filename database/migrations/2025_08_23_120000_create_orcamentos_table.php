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
        Schema::create('orcamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->name('fk_orcamentos_cliente');
            $table->string('status', 16)->default('draft');
            $table->decimal('subtotal', 14, 4)->default(0.0000);
            $table->decimal('desconto', 14, 4)->default(0.0000);
            $table->decimal('total', 14, 4)->default(0.0000);
            $table->date('validade')->nullable();
            $table->foreignId('user_id')->constrained('users')->name('fk_orcamentos_criou');
            $table->text('observacoes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('cliente_id', 'fk_orcamentos_cliente_idx');
            $table->index('user_id', 'fk_orcamentos_criou_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orcamentos');
    }
};
