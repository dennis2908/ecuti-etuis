<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExceptionPp30OfficerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exception_pp30_officer', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('exception_pp30_id');
            $table->unsignedInteger('officer_id');

            $table->foreign('exception_pp30_id')
                ->references('id')
                ->on('exception_pp30')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('officer_id')
                ->references('id')
                ->on('officer')
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
        Schema::dropIfExists('exception_pp30_officer');
    }
}
