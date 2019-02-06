<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnforcementC1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enforcement_c1', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('enforcement_id')->nullable();
            $table->year('start_year')->nullable();
            $table->year('end_year')->nullable();
            $table->decimal('cash_at_hand', 10,2)->nullable();
            $table->decimal('cash_at_bank', 10,2)->nullable();
            $table->decimal('entrance_fee', 10,2)->nullable();
            $table->decimal('monthly_fee', 10,2)->nullable();
            $table->decimal('union_office', 10,2)->nullable();
            $table->decimal('volunteer_fund', 10,2)->nullable();
            $table->decimal('special_collection', 10,2)->nullable();
            $table->decimal('bank_interest', 10,2)->nullable();
            $table->decimal('officer_allowance', 10,2)->nullable();
            $table->decimal('post_shipping', 10,2)->nullable();
            $table->decimal('phone', 10,2)->nullable();
            $table->decimal('stationary', 10,2)->nullable();
            $table->decimal('wage', 10,2)->nullable();
            $table->decimal('meeting_expense', 10,2)->nullable();
            $table->decimal('deposit_payment', 10,2)->nullable();
            $table->decimal('social_payment', 10,2)->nullable();
            $table->decimal('fare', 10,2)->nullable();
            $table->decimal('tax', 10,2)->nullable();
            $table->decimal('rental', 10,2)->nullable();
            $table->decimal('electric_bill', 10,2)->nullable();
            $table->decimal('welfare_aid', 10,2)->nullable();
            $table->decimal('union_payment', 10,2)->nullable();
            $table->decimal('seminar_course', 10,2)->nullable();
            $table->date('cash_at')->nullable();
            $table->decimal('total_at_hand', 10,2)->nullable();
            $table->date('bank_at')->nullable();
            $table->decimal('total_at_bank', 10,2)->nullable();
            $table->decimal('total_income', 10,2)->nullable();
            $table->decimal('total_liability', 10,2)->nullable();
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
        Schema::dropIfExists('enforcement_c1');
    }
}
