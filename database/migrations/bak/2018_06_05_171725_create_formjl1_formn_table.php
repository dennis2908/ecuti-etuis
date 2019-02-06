<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormjl1FormnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formjl1_formn', function (Blueprint $table) {
            $table->increments('id');            
            $table->unsignedInteger('formjl1_id');            
            $table->unsignedInteger('formn_id');

             $table->foreign('formn_id')
                ->references('id')
                ->on('formn')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('formjl1_id')
                ->references('id')
                ->on('formjl1')
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
        Schema::dropIfExists('formjl1_formn');
    }
}
