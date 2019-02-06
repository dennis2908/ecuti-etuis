<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLetterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('letter', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('letter_type_id');
            $table->unsignedInteger('module_id');
            $table->text('data')->nullable();
            $table->morphs('filing');
            $table->nullableMorphs('entity');
            $table->unsignedInteger('created_by_user_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('letter_type_id')
                ->references('id')
                ->on('master_letter_type')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('module_id')
                ->references('id')
                ->on('master_module')
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
        Schema::dropIfExists('letter');
    }
}
