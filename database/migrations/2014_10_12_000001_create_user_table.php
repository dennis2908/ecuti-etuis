<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->nullableMorphs('entity');
            $table->string('name');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->unsignedInteger('user_type_id')->default(3);
            $table->unsignedInteger('user_status_id')->default(2);
            $table->string('picture_url')->nullable();
            $table->rememberToken();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->softDeletes();

            $table->foreign('user_type_id')
                ->references('id')
                ->on('master_user_type')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('user_status_id')
                ->references('id')
                ->on('master_user_status')
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
        Schema::dropIfExists('user');
    }
}
