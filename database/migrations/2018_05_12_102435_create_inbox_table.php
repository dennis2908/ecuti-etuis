<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInboxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inbox', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sender_user_id');
            $table->unsignedInteger('receiver_user_id');
            $table->string('subject');
            $table->text('message');
            $table->unsignedInteger('inbox_status_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('sender_user_id')
                ->references('id')
                ->on('user')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('receiver_user_id')
                ->references('id')
                ->on('user')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('inbox_status_id')
                ->references('id')
                ->on('master_inbox_status')
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
        Schema::dropIfExists('inbox');
    }
}
