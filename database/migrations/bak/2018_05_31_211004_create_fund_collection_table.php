<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFundCollectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_collection', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fund_id');
            $table->unsignedInteger('prior_fund_id');
            $table->date('year');
            $table->string('objective');

            $table->foreign('fund_id')
                ->references('id')
                ->on('fund')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('prior_fund_id')
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
        Schema::dropIfExists('fund_collection');
    }
}
