<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormUTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formu', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('filing');
            $table->unsignedInteger('tenure_id');
            $table->unsignedInteger('address_id');
            $table->unsignedInteger('branch_id')->nullable();
            $table->text('setting')->nullable();
            $table->date('voted_at')->nullable();
            $table->unsignedInteger('total_voters')->nullable();
            $table->unsignedInteger('total_slips')->nullable();
            $table->unsignedInteger('total_supporting')->nullable();
            $table->unsignedInteger('total_against')->nullable();
            $table->boolean('is_supported')->default(1);
            $table->boolean('is_editable')->default(1);
            $table->unsignedInteger('filing_status_id')->default(1);
            $table->unsignedInteger('created_by_user_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('address_id')
                ->references('id')
                ->on('address')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('branch_id')
                ->references('id')
                ->on('branch')
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
        Schema::dropIfExists('formu');
    }
}
