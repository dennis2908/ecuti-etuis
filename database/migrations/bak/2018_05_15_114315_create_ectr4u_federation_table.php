<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEctr4uFederationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ectr4u_federation', function (Blueprint $table) {
            $table->unsignedInteger('ectr4u_id');
            $table->unsignedInteger('user_federation_id');

            $table->foreign('ectr4u_id')
                ->references('id')
                ->on('ectr4u')
                ->onDelete('cascade')
                ->onUpdate('cascade');
                
            $table->foreign('user_federation_id')
                ->references('id')
                ->on('user_federation')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->primary(['ectr4u_id', 'user_federation_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ectr4u_federation');
    }
}
