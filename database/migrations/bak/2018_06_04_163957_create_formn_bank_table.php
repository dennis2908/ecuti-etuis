<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormnBankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formn_bank', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('formn_id');
            $table->string('name');
            $table->decimal('total',10,2);

            $table->foreign('formn_id')
                ->references('id')
                ->on('formn')
                ->onDelete('cascade')
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
        Schema::dropIfExists('formn_bank');
    }
}
