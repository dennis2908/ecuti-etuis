<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterLetterTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_letter_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('module_id');
            $table->string('template_name')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('module_id')
                ->references('id')
                ->on('master_module')
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
        Schema::dropIfExists('master_letter_type');
    }
}
