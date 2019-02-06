<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormUExaminerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formu_examiner', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('formu_id');
            $table->string('name');

            $table->foreign('formu_id')
                ->references('id')
                ->on('formu')
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
        Schema::dropIfExists('formu_examiner');
    }
}
