<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConstitutionChangeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('constitution_change', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('constitution_id');
            $table->unsignedInteger('constitution_item_id');
            $table->unsignedInteger('change_type_id');
            $table->text('justification')->nullable();
            $table->boolean('is_approved')->nullable();
            $table->text('result_details')->nullable();
            $table->unsignedInteger('created_by_user_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('constitution_id')
                ->references('id')
                ->on('constitution')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('constitution_item_id')
                ->references('id')
                ->on('constitution_item')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('change_type_id')
                ->references('id')
                ->on('master_change_type')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('created_by_user_id')
                ->references('id')
                ->on('user')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->unique(['constitution_id', 'constitution_item_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('constitution_change');
    }
}
