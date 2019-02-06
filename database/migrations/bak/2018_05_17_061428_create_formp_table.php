<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formp', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('formpq_id');
            $table->unsignedInteger('address_id')->nullable();
            $table->unsignedInteger('user_federation_id')->nullable();
            $table->date('resolved_at')->nullable();
            $table->unsignedInteger('meeting_type_id')->nullable();
            $table->unsignedInteger('secretary_user_id');
            $table->date('applied_at')->nullable();
            $table->unsignedInteger('created_by_user_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('formpq_id')
                ->references('id')
                ->on('formpq')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('address_id')
                ->references('id')
                ->on('address')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('meeting_type_id')
                ->references('id')
                ->on('master_meeting_type')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('user_federation_id')
                ->references('id')
                ->on('user_federation')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('secretary_user_id')
                ->references('id')
                ->on('user')
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
        Schema::dropIfExists('formp');
    }
}
