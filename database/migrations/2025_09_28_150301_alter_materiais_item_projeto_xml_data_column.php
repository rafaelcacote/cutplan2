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
        Schema::table('materiais_item_projeto', function (Blueprint $table) {
            // Alterar xml_data de text para longText para suportar XMLs grandes
            $table->longText('xml_data')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materiais_item_projeto', function (Blueprint $table) {
            // Reverter longText para text
            $table->text('xml_data')->nullable()->change();
        });
    }
};
