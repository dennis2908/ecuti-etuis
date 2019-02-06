<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterPostcodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_postcode', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->unsignedInteger('district_id');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('district_id')
                ->references('id')
                ->on('master_district')
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
        Schema::dropIfExists('master_postcode');
    }
}
