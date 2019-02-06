<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogFilingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_filing', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('module_id');
            $table->unsignedInteger('activity_type_id');
            $table->morphs('filing');
            $table->unsignedInteger('filing_status_id');
            $table->text('data');
            $table->unsignedInteger('created_by_user_id');
            $table->unsignedInteger('role_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('module_id')
                ->references('id')
                ->on('master_module')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('filing_status_id')
                ->references('id')
                ->on('master_filing_status')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('activity_type_id')
                ->references('id')
                ->on('master_activity_type')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('created_by_user_id')
                ->references('id')
                ->on('user')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on('role')
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
        Schema::dropIfExists('log_filing');
    }
}
