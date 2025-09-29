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
        Schema::create('clientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome', 150);
            $table->string('documento', 32)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('telefone', 50)->nullable();
            $table->unsignedBigInteger('endereco_id');
            $table->text('observacoes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('user_id');

            $table->foreign('endereco_id')->references('id')->on('enderecos')->onDelete('restrict');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->index('endereco_id', 'fk_clientes_endereco');
            $table->index('user_id', 'fk_clientes_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
};
