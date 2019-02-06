<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormbb3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formbb3', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('formbb_id');
            $table->decimal('entrance_fee', 10, 2)->nullable();
            $table->decimal('yearly_fee', 10, 2)->nullable();
            $table->unsignedInteger('convention_yearly')->nullable();
            $table->unsignedInteger('first_member')->nullable();
            $table->unsignedInteger('next_member')->nullable();
            $table->decimal('max_savings', 10, 2)->nullable();
            $table->decimal('max_expenses', 10, 2)->nullable();
            $table->unsignedInteger('created_by_user_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('formbb_id')
                ->references('id')
                ->on('formbb')
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
        Schema::dropIfExists('formbb3');
    }
}
