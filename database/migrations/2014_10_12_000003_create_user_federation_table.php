<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFederationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_federation', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('registration_no')->nullable();
            $table->timestamp('registered_at');
            $table->unsignedInteger('province_office_id')->nullable();
            $table->unsignedInteger('industry_type_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->softDeletes();

            $table->foreign('province_office_id')
                ->references('id')
                ->on('master_province_office')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('industry_type_id')
                ->references('id')
                ->on('master_industry_type')
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
        Schema::dropIfExists('user_federation');
    }
}