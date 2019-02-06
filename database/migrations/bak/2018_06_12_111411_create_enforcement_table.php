<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnforcementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enforcement', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('entity');
            $table->unsignedInteger('branch_id')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->unsignedInteger('state_id')->nullable();
            $table->unsignedInteger('district_id')->nullable();
            $table->unsignedInteger('filing_status_id')->default(1);
            $table->date('applied_at')->nullable();
            $table->unsignedInteger('created_by_user_id');
            $table->boolean('is_editable')->default(1);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('branch_id')
                ->references('id')
                ->on('branch')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('state_id')
                ->references('id')
                ->on('master_state')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('district_id')
                ->references('id')
                ->on('master_district')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('filing_status_id')
                ->references('id')
                ->on('master_filing_status')
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
        Schema::dropIfExists('enforcement');
    }
}
