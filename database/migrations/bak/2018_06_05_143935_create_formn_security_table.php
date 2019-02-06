<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormnSecurityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formn_security', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('formn_id');
            $table->text('description');
            $table->decimal('external_value',10,2);
            $table->decimal('cost_value',10,2);
            $table->decimal('market_value',10,2);
            $table->decimal('cash',10,2);
            $table->unsignedInteger('created_by_user_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('formn_id', 'formn_security_formn_foreign')
                ->references('id')
                ->on('formn')
                ->onDelete('cascade')
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
        Schema::dropIfExists('formn_security');
    }
}
