<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('user_union_id');
            $table->unsignedInteger('address_id')->nullable();
            $table->string('secretary_name')->nullable();
            $table->string('secretary_email')->nullable();
            $table->string('secretary_phone')->nullable();
            $table->integer('total_member')->nullable();
            $table->date('established_at')->nullable();
            $table->date('meeting_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            
            $table->foreign('user_union_id')
                ->references('id')
                ->on('user_union')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('address_id')
                ->references('id')
                ->on('address')
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
        Schema::dropIfExists('branch');
    }
}
