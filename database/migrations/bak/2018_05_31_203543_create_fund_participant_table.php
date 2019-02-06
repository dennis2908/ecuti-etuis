<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFundParticipantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_participant', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fund_id');
            $table->unsignedInteger('party_type_id')->nullable();
            $table->string('member_no')->nullable();
            $table->string('name')->nullable();
            $table->string('occupation')->nullable();
            $table->string('registration_no')->nullable();
            $table->text('address_company')->nullable();
            $table->string('identification_no')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();

            $table->foreign('fund_id')
                ->references('id')
                ->on('fund')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('party_type_id')
                ->references('id')
                ->on('master_party_type')
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
        Schema::dropIfExists('fund_participant');
    }
}
