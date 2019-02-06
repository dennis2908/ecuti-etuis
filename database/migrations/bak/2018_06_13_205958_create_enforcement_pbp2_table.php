<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnforcementPbp2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enforcement_pbp2', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('enforcement_id');
            $table->unsignedInteger('province_office_id')->nullable();
            $table->timestamp('investigation_date')->nullable();
            $table->date('old_investigation_date')->nullable();
            $table->text('location')->nullable();
            $table->boolean('is_administration_record')->default(0);
            $table->boolean('is_finance_record')->default(0);
            $table->boolean('is_complaint_investigation')->default(0);
            $table->string('complaint_reference_no')->nullable();
            $table->unsignedInteger('latest_address_id')->nullable();
            $table->string('fax')->nullable();
            $table->string('website')->nullable();
            $table->string('dashboard')->nullable();
            $table->unsignedInteger('address_type_id')->nullable();
            $table->boolean('is_fee_registration')->default(0);
            $table->date('kpks_approved_at')->nullable();
            $table->string('fee_details')->nullable();
            $table->unsignedInteger('registered_male')->nullable();
            $table->unsignedInteger('registered_female')->nullable();
            $table->unsignedInteger('rightful_male')->nullable();
            $table->unsignedInteger('rightful_female')->nullable();
            $table->unsignedInteger('union_male')->nullable();
            $table->unsignedInteger('union_female')->nullable();
            $table->unsignedInteger('foreign_male')->nullable();
            $table->unsignedInteger('foreign_female')->nullable();
            $table->unsignedInteger('total_book_saved')->nullable();
            $table->unsignedInteger('total_book_used')->nullable();
            $table->unsignedInteger('total_book_unused')->nullable();
            $table->string('num_book_saved')->nullable();
            $table->string('num_book_used')->nullable();
            $table->string('num_book_unused')->nullable();
            $table->string('series_book_saved')->nullable();
            $table->string('series_book_used')->nullable();
            $table->string('series_book_unused')->nullable();
            $table->text('justification_nonformat')->nullable();
            $table->boolean('is_exampted')->default(0);
            $table->boolean('is_accepted')->default(0);
            $table->date('cash_book_update_at')->nullable();
            $table->boolean('is_account_balanced_monthly')->default(0);
            $table->text('justification_exceed_limit')->nullable();
            $table->decimal('cash_limit', 10,2)->nullable();
            $table->date('balance_at')->nullable();
            $table->decimal('saving_cash', 10,2)->nullable();
            $table->decimal('saving_bank', 10,2)->nullable();
            $table->decimal('saving_at_hand', 10,2)->nullable();
            $table->boolean('is_monthly_maintained')->default(1);
            $table->boolean('is_stock_maintained')->default(0);
            $table->boolean('is_cash_updated')->default(0);
            $table->boolean('is_receipt_printed')->default(0);
            $table->boolean('is_receipt_issued')->default(0);
            $table->boolean('is_receipt_given')->default(0);
            $table->boolean('is_receipt_duplicated')->default(0);
            $table->string('receipt_no')->nullable();
            $table->date('receipt_at')->nullable();
            $table->text('receipt_purpose')->nullable();
            $table->decimal('total_receipt', 10,2)->nullable();
            $table->boolean('is_receipt_verified')->default(0);
            $table->boolean('is_journal_maintained')->default(0);
            $table->boolean('is_journal_updated')->default(0);
            $table->boolean('is_ledger_maintained')->default(0);
            $table->boolean('is_payment_recorded')->default(0);
            $table->boolean('is_ledger_recorded')->default(0);
            $table->boolean('is_ledger_updated')->default(0);
            $table->boolean('is_voucher_maintained')->default(0);
            $table->boolean('is_voucher_issued')->default(0);
            $table->boolean('is_voucher_signed')->default(0);
            $table->boolean('is_voucher_attached')->default(0);
            $table->boolean('is_voucher_arranged')->default(0);
            $table->string('voucher_no')->nullable();
            $table->date('voucher_at')->nullable();
            $table->text('voucher_purpose')->nullable();
            $table->decimal('total_voucher', 10,2)->nullable();
            $table->boolean('is_asset_registered')->default(0);
            $table->text('justification_unregistered')->nullable();
            $table->text('asset_purchased_notes')->nullable();
            $table->text('depreciation_approved_notes')->nullable();
            $table->boolean('is_copy_saved')->default(0);
            $table->unsignedInteger('budget_meeting_type_id')->nullable();
            $table->date('statement_start_at')->nullable();
            $table->date('statement_end_at')->nullable();
            $table->date('audited_at')->nullable();
            $table->year('latest_formn_year')->nullable();
            $table->year('missed_formn_year')->nullable();
            $table->text('justification_notsubmit')->nullable();
            $table->text('non_external_auditor')->nullable();
            $table->unsignedInteger('meeting_duration_id')->nullable();
            $table->boolean('is_agenda_meeting')->default(0);
            $table->boolean('is_enough_corum')->default(0);
            $table->boolean('is_minutes_prepared')->default(0);
            $table->boolean('is_ammendment_approved')->default(0);
            $table->boolean('is_complaint')->default(0);
            $table->date('last_meeting_at')->nullable();
            $table->year('tenure_start')->nullable();
            $table->year('tenure_end')->nullable();
            $table->year('tenure_officer_start')->nullable();
            $table->year('tenure_officer_end')->nullable();
            $table->date('last_election_at')->nullable();
            $table->date('forml_at')->nullable();
            $table->date('submitted_at')->nullable();
            $table->date('exception_civil_at')->nullable();
            $table->date('exception_minister_at')->nullable();
            $table->boolean('is_officer_changed')->default(0);
            $table->boolean('is_changes_approved')->default(0);
            $table->boolean('is_notice_submitted')->default(0);
            $table->boolean('is_worker_appointed')->default(0);
            $table->boolean('is_appointment_approved')->default(0);
            $table->boolean('is_worker_changes')->default(0);
            $table->boolean('is_worker_notice_submitted')->default(0);
            $table->boolean('is_committee_meeting')->default(0);
            $table->boolean('is_committee_verified')->default(0);
            $table->boolean('is_committee_enough')->default(0);
            $table->date('last_committee_at')->nullable();
            $table->unsignedInteger('total_examiner')->nullable();
            $table->boolean('is_d1_obey')->default(0);
            $table->boolean('is_arbitrator_appointed')->default(0);
            $table->text('comment')->nullable();
            $table->unsignedInteger('created_by_user_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('enforcement_id')
                ->references('id')
                ->on('enforcement')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('latest_address_id')
                ->references('id')
                ->on('address')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('province_office_id')
                ->references('id')
                ->on('master_province_office')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('address_type_id')
                ->references('id')
                ->on('master_address_type')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('budget_meeting_type_id')
                ->references('id')
                ->on('master_meeting_type')
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
        Schema::dropIfExists('enforcement_pbp2');
    }
}
