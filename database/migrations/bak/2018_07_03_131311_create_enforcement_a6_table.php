<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnforcementA6Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enforcement_a6', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('enforcement_id');
            $table->string('company_name')->nullable();
            $table->string('duration')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('enforcement_id')
                ->references('id')
                ->on('enforcement')
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
        Schema::dropIfExists('enforcement_a6');
    }
}
