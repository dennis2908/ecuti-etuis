<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForml1AppointedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forml1_appointed', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('forml1_id');
            $table->string('name');
            $table->string('appointment');
            $table->string('identification_no');
            $table->date('date_of_birth');
            $table->string('occupation');
            $table->date('appointed_at');
            $table->unsignedInteger('address_id');
            $table->unsignedInteger('created_by_user_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('forml1_id')
                ->references('id')
                ->on('forml1')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('address_id')
                ->references('id')
                ->on('address')
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
        Schema::dropIfExists('forml1_appointed');
    }
}
