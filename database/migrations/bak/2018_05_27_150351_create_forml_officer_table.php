<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormlOfficerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forml_officer', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('forml_id');
            $table->string('name');
            $table->unsignedInteger('designation_id');
            $table->date('held_at');
            $table->string('occupation');
            $table->unsignedInteger('nationality_country_id')->nullable();
            $table->string('identification_no');
            $table->unsignedInteger('address_id');
            $table->date('date_of_birth');
            $table->unsignedInteger('created_by_user_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('forml_id')
                ->references('id')
                ->on('forml')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('designation_id')
                ->references('id')
                ->on('master_designation')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('nationality_country_id')
                ->references('id')
                ->on('master_country')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('address_id')
                ->references('id')
                ->on('address')
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
        Schema::dropIfExists('forml_officer');
    }
}
