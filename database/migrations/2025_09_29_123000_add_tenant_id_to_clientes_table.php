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
        Schema::table('clientes', function (Blueprint $table) {
            $table->unsignedBigInteger('tenant_id')->after('user_id');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('restrict');
            $table->index('tenant_id', 'fk_clientes_tenant');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropForeign('fk_clientes_tenant');
            $table->dropIndex('fk_clientes_tenant');
            $table->dropColumn('tenant_id');
        });
    }
};