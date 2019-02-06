<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormwRequesterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formw_requester', function (Blueprint $table) {

            $table->unsignedInteger('formw_id');
            $table->unsignedInteger('officer_id');

            $table->foreign('formw_id')
                ->references('id')
                ->on('formw')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('officer_id')
                ->references('id')
                ->on('officer')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->primary(['formw_id', 'officer_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('formw_requester');
    }
}
