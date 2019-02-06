<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnforcementMeetingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enforcement_meeting', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('enforcement_id');
            $table->string('total_meeting')->nullable();
            $table->date('meeting_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('enforcement_id')
                ->references('id')
                ->on('enforcement')
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
        Schema::dropIfExists('enforcement_meeting');
    }
}
