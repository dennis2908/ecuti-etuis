<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterDistrictTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_district', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('state_id');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('state_id')
                ->references('id')
                ->on('master_state')
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
        Schema::dropIfExists('master_district');
    }
}
