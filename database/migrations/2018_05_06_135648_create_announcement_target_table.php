<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnnouncementTargetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcement_target', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('announcement_id');
            $table->unsignedInteger('role_id');

            $table->foreign('announcement_id')
                ->references('id')
                ->on('announcement')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on('role')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->unique(['announcement_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('announcement_target');
    }
}
