<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFundBankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_bank', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fund_id');
            $table->string('name');
            $table->string('account_no');
            $table->string('balance');

            $table->foreign('fund_id')
                ->references('id')
                ->on('fund')
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
        Schema::dropIfExists('fund_bank');
    }
}
