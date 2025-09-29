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
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 150);
            $table->string('cnpj', 18)->nullable();
            $table->string('logo')->nullable();
            $table->foreignId('endereco_id')->nullable()->constrained('enderecos')->name('fk_tenants_endereco');
            $table->string('telefone', 50)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('slug')->unique();
            $table->timestamps();
            
            // Indexes
            $table->index('endereco_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
