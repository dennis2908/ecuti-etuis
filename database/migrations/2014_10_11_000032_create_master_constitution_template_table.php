<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterConstitutionTemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_constitution_template', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->text('content');
            $table->unsignedInteger('parent_constitution_template_id')->nullable();
            $table->unsignedInteger('below_constitution_template_id')->nullable();
            $table->unsignedInteger('constitution_type_id');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('parent_constitution_template_id', 'parent_foreign')
                ->references('id')
                ->on('master_constitution_template')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('constitution_type_id')
                ->references('id')
                ->on('master_constitution_type')
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
        Schema::dropIfExists('master_constitution_template');
    }
}
