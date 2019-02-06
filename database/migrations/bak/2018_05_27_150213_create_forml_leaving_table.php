<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormlLeavingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forml_leaving', function (Blueprint $table) {

            $table->unsignedInteger('forml_id');
            $table->unsignedInteger('officer_id');
            $table->date('left_at');

            $table->foreign('forml_id')
                ->references('id')
                ->on('forml')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('officer_id')
                ->references('id')
                ->on('officer')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->primary(['forml_id', 'officer_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forml_leaving');
    }
}
