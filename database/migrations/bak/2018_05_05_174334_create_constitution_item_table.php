<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConstitutionItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('constitution_item', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('constitution_id');
            $table->string('code');
            $table->text('content');
            $table->unsignedInteger('parent_constitution_item_id')->nullable();
            $table->unsignedInteger('below_constitution_item_id')->nullable();
            $table->unsignedInteger('constitution_template_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->softDeletes();

            $table->foreign('constitution_id')
                ->references('id')
                ->on('constitution')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('parent_constitution_item_id')
                ->references('id')
                ->on('constitution_item')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('below_constitution_item_id')
                ->references('id')
                ->on('constitution_item')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('constitution_template_id')
                ->references('id')
                ->on('master_constitution_template')
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
        Schema::dropIfExists('constitution_item');
    }
}
