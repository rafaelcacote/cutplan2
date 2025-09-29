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
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome', 150);
            $table->string('documento', 32)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('telefone', 50)->nullable();
            $table->unsignedBigInteger('endereco_id');
            $table->unsignedBigInteger('user_id');
            $table->text('observacoes')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('endereco_id', 'fk_fornecedores_endereco')->references('id')->on('enderecos');
            $table->foreign('user_id', 'fk_fornecedores_user')->references('id')->on('users');
            $table->index('endereco_id', 'fk_fornecedores_endereco');
            $table->index('user_id', 'fk_fornecedores_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fornecedores');
    }
};
