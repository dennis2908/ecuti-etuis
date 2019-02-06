<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormOUnionTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formo_union', function (Blueprint $table) {
            $table->unsignedInteger('formo_id');
            $table->unsignedInteger('user_union_id');

            $table->foreign('formo_id')
                ->references('id')
                ->on('formo')
                ->onDelete('cascade')
                ->onUpdate('cascade');
                
            $table->foreign('user_union_id')
                ->references('id')
                ->on('user_union')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->primary(['formo_id', 'user_union_id']);
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('formo_union');
    }
}