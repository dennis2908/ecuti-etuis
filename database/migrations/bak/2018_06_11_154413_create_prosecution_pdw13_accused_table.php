<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProsecutionPdw13AccusedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prosecution_pdw13_accused', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('prosecution_pdw13_id');
            $table->string('accused');
            $table->string('identification_no');

            $table->foreign('prosecution_pdw13_id')
                ->references('id')
                ->on('prosecution_pdw13')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prosecution_pdw13_accused');
    }
}
