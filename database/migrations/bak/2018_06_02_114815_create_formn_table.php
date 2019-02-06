<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formn', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tenure_id');
            $table->string('certification_no')->nullable();
            $table->unsignedInteger('address_id')->nullable();
            $table->unsignedInteger('year')->nullable();
            $table->unsignedInteger('total_member_start')->nullable();
            $table->unsignedInteger('total_member_accepted')->nullable();
            $table->unsignedInteger('total_member_leave')->nullable();
            $table->unsignedInteger('total_member_end')->nullable();
            $table->unsignedInteger('total_male')->nullable();
            $table->unsignedInteger('total_female')->nullable();
            $table->unsignedInteger('male_malay')->nullable();
            $table->unsignedInteger('male_chinese')->nullable();
            $table->unsignedInteger('male_indian')->nullable();
            $table->unsignedInteger('male_others')->nullable();
            $table->unsignedInteger('female_malay')->nullable();
            $table->unsignedInteger('female_chinese')->nullable();
            $table->unsignedInteger('female_indian')->nullable();
            $table->unsignedInteger('female_others')->nullable();
            $table->string('duration')->nullable();
            $table->decimal('accept_balance_start', 10, 2)->nullable();
            $table->decimal('accept_entrance_fee', 10, 2)->nullable();
            $table->decimal('accept_membership_fee', 10, 2)->nullable();
            $table->decimal('accept_sponsorship', 10, 2)->nullable();
            $table->decimal('accept_sales', 10, 2)->nullable();
            $table->decimal('accept_interest', 10, 2)->nullable();
            $table->decimal('total_accept', 10, 2)->nullable();
            $table->decimal('pay_officer_salary', 10, 2)->nullable();
            $table->decimal('pay_organization_salary', 10, 2)->nullable();
            $table->decimal('pay_auditor_fee', 10, 2)->nullable();
            $table->decimal('pay_attorney_expenditure', 10, 2)->nullable();
            $table->decimal('pay_tred_expenditure', 10, 2)->nullable();
            $table->decimal('pay_compensation', 10, 2)->nullable();
            $table->decimal('pay_sick_benefit', 10, 2)->nullable();
            $table->decimal('pay_study_benefit', 10, 2)->nullable();
            $table->decimal('pay_publication_cost', 10, 2)->nullable();
            $table->decimal('pay_rental', 10, 2)->nullable();
            $table->decimal('pay_stationary', 10, 2)->nullable();
            $table->decimal('pay_balance_end', 10, 2)->nullable();
            $table->decimal('total_pay', 10, 2)->nullable();
            $table->decimal('liability_fund', 10, 2)->nullable();
            $table->decimal('total_liability', 10, 2)->nullable();
            $table->decimal('asset_security', 10, 2)->nullable();
            $table->string('asset_property')->nullable();
            $table->decimal('asset_property_total', 10, 2)->nullable();
            $table->decimal('asset_furniture', 10, 2)->nullable();
            $table->string('other_asset')->nullable();
            $table->decimal('other_asset_total', 10, 2)->nullable();
            $table->decimal('total_asset', 10, 2)->nullable();
            $table->unsignedInteger('signed_by_user_id')->nullable();
            $table->unsignedInteger('signed_district_id')->nullable();
            $table->unsignedInteger('signed_state_id')->nullable();
            $table->date('signed_at')->nullable();
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

            $table->foreign('signed_district_id')
                ->references('id')
                ->on('master_district')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('signed_state_id')
                ->references('id')
                ->on('master_state')
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

            $table->foreign('signed_by_user_id')
                ->references('id')
                ->on('officer')
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
        Schema::dropIfExists('formn');
    }
}
