<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormnLeavingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formn_leaving', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('formn_id');
            $table->string('name');
            $table->unsignedInteger('designation_id');
            $table->date('left_at');
            $table->unsignedInteger('created_by_user_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('formn_id')
                ->references('id')
                ->on('formn')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('designation_id')
                ->references('id')
                ->on('master_designation')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('created_by_user_id')
                ->references('id')
                ->on('user')
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
        Schema::dropIfExists('formn_leaving');
    }
}
