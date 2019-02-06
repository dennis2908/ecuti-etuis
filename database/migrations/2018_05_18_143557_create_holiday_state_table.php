<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHolidayStateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holiday_state', function (Blueprint $table) {

            $table->unsignedInteger('holiday_id');
            $table->unsignedInteger('state_id');

            $table->foreign('holiday_id')
                ->references('id')
                ->on('holiday')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('state_id')
                ->references('id')
                ->on('master_state')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->primary(['holiday_id', 'state_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('holiday_state');
    }
}
