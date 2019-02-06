<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_staff', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('role_id')->default(3);
            $table->unsignedInteger('province_office_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->softDeletes();

            $table->foreign('role_id')
                ->references('id')
                ->on('role')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('province_office_id')
                ->references('id')
                ->on('master_province_office')
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
        Schema::dropIfExists('user_staff');
    }
}