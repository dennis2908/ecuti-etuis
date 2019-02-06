<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reference', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('filing');
            $table->string('reference_no');
            $table->unsignedInteger('reference_type_id');
            $table->unsignedInteger('module_id');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('reference_type_id')
                ->references('id')
                ->on('master_reference_type')
                ->onDelete('restrict')
                ->onUpdate('cascade');

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
        Schema::dropIfExists('reference');
    }
}
