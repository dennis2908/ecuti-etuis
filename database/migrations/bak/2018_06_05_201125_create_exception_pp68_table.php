<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExceptionPp68Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exception_pp68', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tenure_id');
            $table->unsignedInteger('address_id')->nullable();

            $table->boolean('is_fee_excepted')->default(0);
            $table->text('justification_fee')->nullable();
            $table->boolean('is_fee_approved')->nullable();
            $table->text('justification_fee_approved')->nullable();

            $table->boolean('is_receipt_excepted')->default(0);
            $table->text('justification_receipt')->nullable();
            $table->boolean('is_receipt_approved')->nullable();
            $table->text('justification_receipt_approved')->nullable();

            $table->boolean('is_computer_excepted')->default(0);
            $table->text('justification_computer')->nullable();
            $table->boolean('is_computer_approved')->nullable();
            $table->text('justification_computer_approved')->nullable();

            $table->boolean('is_system_excepted')->default(0);
            $table->text('justification_system')->nullable();
            $table->boolean('is_system_approved')->nullable();
            $table->text('justification_system_approved')->nullable();

            $table->date('applied_at')->nullable();
            $table->unsignedInteger('filing_status_id')->default(1);
            $table->boolean('is_editable')->default(1);
            $table->unsignedInteger('created_by_user_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('tenure_id')
                ->references('id')
                ->on('tenure')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('address_id')
                ->references('id')
                ->on('address')
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
        Schema::dropIfExists('exception_pp68');
    }
}
