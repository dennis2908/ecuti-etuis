<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class EnforcementPBP2 extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'enforcement_pbp2';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'enforcement_id',
        'province_office_id',
        'investigation_date',
        'old_investigation_date',
        'location',
        'is_administration_record',
        'is_finance_record',
        'is_complaint_investigation',
        'complaint_reference_no',
        'latest_address_id',
        'dashboard',
        'address_type_id',
        'is_fee_registration',
        'kpks_approved_at',
        'fee_details',
        'justification_nonformat',
        'is_exampted',
        'is_accepted',
        'cash_book_update_at',
        'is_account_balanced_monthly',
        'justification_exceed_limit',
        'cash_limit',
        'balance_at',
        'saving_cash',
        'saving_bank',
        'saving_at_hand',
        'is_monthly_maintained',
        'is_stock_maintained',
        'is_cash_updated',
        'is_receipt_printed',
        'is_receipt_issued',
        'is_receipt_given',
        'is_receipt_duplicated',
        'receipt_no',
        'receipt_at',
        'receipt_purpose',
        'total_receipt',
        'is_receipt_verified',
        'is_journal_maintained',
        'is_journal_updated',
        'is_ledger_updated',
        'is_payment_recorded',
        'is_ledger_recorded',
        'is_ledger_updated',
        'is_voucher_maintained',
        'is_voucher_issued',
        'is_voucher_signed',
        'is_voucher_attached',
        'is_voucher_arranged',
        'voucher_no',
        'voucher_at',
        'voucher_purpose',
        'total_voucher',
        'is_asset_registered',
        'justification_unregistered',
        'asset_purchased_notes',
        'depreciation_approved_notes',
        'is_copy_saved',
        'budget_meeting_type_id',
        'statement_start_at',
        'statement_end_at',
        'audited_at',
        'latest_formn_year',
        'missed_formn_year',
        'justification_notsubmit',
        'non_external_auditor',
        'meeting_duration_id',
        'is_agenda_meeting',
        'is_enough_corum',
        'is_minutes_prepared',
        'is_ammendment_approved',
        'is_complaint',
        'last_meeting_at',
        'tenure_start',
        'tenure_end',
        'tenure_officer_start',
        'tenure_officer_end',
        'last_election_at',
        'forml_date',
        'submitted_at',
        'exception_civil_at',
        'exception_minister_at',
        'is_officer_changed',
        'is_changes_approved',
        'is_notice_submitted',
        'is_worker_appointed',
        'is_appointment_approved',
        'is_worker_changes',
        'is_worker_notice_submitted',
        'is_committee_meeting',
        'is_committee_verified',
        'is_committee_enough',
        'last_committee_at',
        'total_examiner',
        'is_d1_obey',
        'is_arbitrator_appointed',
        'justification',
        'created_by_user_id',
    ];

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'id');
    }

    public function enforcement() {
        return $this->belongsTo('App\FilingModel\Enforcement', 'enforcement_id', 'id');
    }

    public function latest_address() {
        return $this->belongsTo('App\OtherModel\Address', 'latest_address_id', 'id');
    }

    public function province_office() {
        return $this->belongsTo('App\MasterModel\MasterProvinceOffice', 'province_office_id', 'id');
    }

    public function address_type() {
        return $this->belongsTo('App\MasterModel\MasterAddressType', 'address_type_id', 'id');
    }

    public function meeting_type() {
        return $this->belongsTo('App\MasterModel\MasterMeetingType', 'budget_meeting_type_id', 'id');
    }

}
