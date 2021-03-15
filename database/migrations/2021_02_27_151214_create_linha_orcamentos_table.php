<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinhaOrcamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('linha_orcamentos', function (Blueprint $table) {
            $table->id();
            $table->text("descricao");
            $table->decimal("valor_unitario", 12, 2, true);
            $table->integer("quantidade");
            $table->foreignId('orcamento_id')->constrained('orcamentos')->onDelete("CASCADE");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('linha_orcamentos');
    }
}
