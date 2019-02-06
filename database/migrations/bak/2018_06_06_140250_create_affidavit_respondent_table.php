<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAffidavitRespondentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affidavit_respondent', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('affidavit_id');
            $table->string('respondent');

            $table->foreign('affidavit_id')
                ->references('id')
                ->on('affidavit')
                ->onDelete('cascade')
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
        Schema::dropIfExists('affidavit_respondent');
    }
}
