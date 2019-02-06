<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_system', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('module_id');
            $table->unsignedInteger('activity_type_id');
            $table->text('description');
            $table->text('data_old')->nullable();
            $table->text('data_new')->nullable();
            $table->text('url');
            $table->string('method')->default('GET');
            $table->string('ip_address')->nullable();
            $table->unsignedInteger('created_by_user_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('module_id')
                ->references('id')
                ->on('master_module')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('activity_type_id')
                ->references('id')
                ->on('master_activity_type')
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
        Schema::dropIfExists('log_system');
    }
}
