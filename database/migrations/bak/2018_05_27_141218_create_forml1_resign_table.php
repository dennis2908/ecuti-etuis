<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForml1ResignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forml1_resign', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('forml1_id');
            $table->unsignedInteger('worker_id');
            $table->date('left_at');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('forml1_id')
                ->references('id')
                ->on('forml1')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('worker_id')
                ->references('id')
                ->on('worker')
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
        Schema::dropIfExists('forml1_resign');
    }
}
