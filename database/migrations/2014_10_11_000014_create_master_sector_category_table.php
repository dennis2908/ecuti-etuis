<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterSectorCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_sector_category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('sector_id');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('sector_id')
                ->references('id')
                ->on('master_sector')
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
        Schema::dropIfExists('master_sector_category');
    }
}
