<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orcamentos', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->after('id');
        });

        // Gerar UUIDs para registros existentes
        \DB::table('orcamentos')->whereNull('uuid')->update([
            'uuid' => \DB::raw('(SELECT UUID())')
        ]);

        // Tornar o campo único após preencher os registros existentes
        Schema::table('orcamentos', function (Blueprint $table) {
            $table->unique('uuid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orcamentos', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
