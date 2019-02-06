<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormb4Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formb4', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('formb_id');
            $table->string('membership_target')->nullable();
            $table->string('paid_by')->nullable();
            $table->decimal('entrance_fee', 10, 2)->nullable();
            $table->decimal('monthly_fee', 10, 2)->nullable();
            $table->string('workplace')->nullable();
            $table->decimal('fixed_fee', 10, 2)->nullable();
            $table->unsignedInteger('percentage_fee')->nullable();
            $table->unsignedInteger('conference_yearly')->nullable();
            $table->unsignedInteger('rep_yearly')->nullable();
            $table->unsignedInteger('meeting_yearly')->nullable();
            $table->unsignedInteger('first_member')->nullable();
            $table->unsignedInteger('next_member')->nullable();
            $table->unsignedInteger('max_rep')->nullable();
            $table->decimal('max_savings', 10, 2)->nullable();
            $table->decimal('max_expenses', 10, 2)->nullable();
            $table->unsignedInteger('min_member')->nullable();
            $table->unsignedInteger('low_member')->nullable();
            $table->unsignedInteger('total_ajk')->nullable();
            $table->unsignedInteger('ajk_yearly')->nullable();
            $table->decimal('branch_max_savings', 10, 2)->nullable();
            $table->decimal('branch_max_expenses', 10, 2)->nullable();
            $table->unsignedInteger('created_by_user_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('formb_id')
                ->references('id')
                ->on('formb')
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
        Schema::dropIfExists('formb4');
    }
}
