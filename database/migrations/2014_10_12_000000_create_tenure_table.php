<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTenureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenure', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('entity');
            $table->unsignedInteger('meeting_type_id')->nullable();
            $table->date('meeting_at')->nullable();
            $table->unsignedInteger('duration')->nullable();
            $table->unsignedInteger('start_year')->nullable();
            $table->unsignedInteger('end_year')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('meeting_type_id')
                ->references('id')
                ->on('master_meeting_type')
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
        Schema::dropIfExists('tenure');
    }
}
