<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enderecos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('endereco', 150);
            $table->string('numero', 10)->nullable();
            $table->string('complemento', 150)->nullable();
            $table->string('bairro', 45)->nullable();
            $table->unsignedBigInteger('municipio_id');
            $table->string('cep', 20)->nullable();
            $table->string('referencia', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('municipio_id', 'fk_enderecos_municipios_idx');
            $table->foreign('municipio_id', 'fk_enderecos_municipios')
                ->references('id')->on('municipios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enderecos');
    }
};
