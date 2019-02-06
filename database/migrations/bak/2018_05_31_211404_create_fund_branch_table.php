<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFundBranchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_branch', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fund_id');
            $table->unsignedInteger('branch_id')->nullable();

            $table->foreign('fund_id')
                ->references('id')
                ->on('fund')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('branch_id')
                ->references('id')
                ->on('branch')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->unique(['fund_id', 'branch_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fund_branch');
    }
}
