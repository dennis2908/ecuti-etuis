<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProsecutionPdw01Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prosecution_pdw01', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('prosecution_id');
            $table->string('subject')->nullable();
            $table->unsignedInteger('province_office_id')->nullable();
            $table->string('report_reference_no')->nullable();
            $table->date('report_date')->nullable();
            $table->string('fault')->nullable();
            $table->date('applied_at')->nullable();
            $table->boolean('is_editable')->default(1);
            $table->unsignedInteger('created_by_user_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('prosecution_id')
                ->references('id')
                ->on('prosecution')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('province_office_id')
                ->references('id')
                ->on('master_province_office')
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
        Schema::dropIfExists('prosecution_pdw01');
    }
}
