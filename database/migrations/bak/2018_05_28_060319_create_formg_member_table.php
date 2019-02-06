<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormgMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formg_member', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('formg_id');
            $table->string('name');

            $table->foreign('formg_id')
                ->references('id')
                ->on('formg')
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
        Schema::dropIfExists('formg_member');
    }
}
