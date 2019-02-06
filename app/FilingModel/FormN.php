<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class FormN extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'formn';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tenure_id',
        'address_id',
        'year',
        'total_member_start',
        'total_member_accepted',
        'total_member_out',
        'total_member_end',
        'total_male',
        'total_female',
        'male_malay',
        'male_chinese',
        'male_indian',
        'male_others',
        'female_malay',
        'female_chinese',
        'female_indian',
        'female_others',
        'duration',
        'accept_balance_start',
        'accept_entrance_fee',
        'accept_membership_fee',
        'accept_sponsorship',
        'accept_sales',
        'accept_interest',
        'total_accept',
        'accept_membership_fee',
        'pay_officer_salary',
        'pay_organization_salary',
        'pay_auditor_fee',
        'pay_attorney_expenditure',
        'pay_tred_expenditure',
        'pay_compensation',
        'pay_sick_benefit',
        'pay_study_benefit',
        'pay_publication_cost',
        'pay_rental',
        'pay_stationary',
        'pay_balance_end',
        'total_pay',
        'liability_fund',
        'total_liability',
        'asset_sacurity',
        'asset_property',
        'asset_property_total',
        'asset_furniture',
        'other_asset',
        'other_asset_total',
        'total_asset',
        'signed_by',
        'district_id',
        'state_id',
        'signed_at',
        'applied_at',
        'filing_status_id',
        'is_editable',
        'created_by_user_id',
    ];

    public function references() {
        return $this->morphMany('App\FilingModel\Reference', 'filing');
    }

    public function tenure() {
        return $this->belongsTo('App\FilingModel\Tenure', 'tenure_id', 'id');
    }

    public function address() {
        return $this->belongsTo('App\OtherModel\Address', 'address_id', 'id');
    }

    public function district() {
        return $this->belongsTo('App\MasterModel\MasterDistrict', 'signed_district_id', 'id');
    }

    public function state() {
        return $this->belongsTo('App\MasterModel\MasterState', 'signed_state_id', 'id');
    }

    public function status() {
        return $this->belongsTo('App\MasterModel\MasterFilingStatus', 'filing_status_id', 'id');
    }

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'id');
    }

    public function signed_by() {
        return $this->belongsTo('App\FilingModel\Officer', 'signed_by_user_id', 'id');
    }

    public function letters() {
        return $this->morphMany('App\OtherModel\Letter','filing');
    }

    public function distributions(){
        return $this->morphMany('App\FilingModel\Distribution','filing');
    }

    public function attachments() {
        return $this->morphMany('App\OtherModel\Attachment', 'filing');
    }

    public function logs() {
        return $this->morphMany('App\LogModel\LogFiling', 'filing');
    }

    public function queries() {
        return $this->morphMany('App\FilingModel\Query', 'filing');
    }

    public function officers() {
        return $this->hasMany('App\FilingModel\FormNAppointed', 'formn_id', 'id');
    }

    public function leaving_officers() {
        return $this->hasMany('App\FilingModel\FormNLeaving', 'formn_id', 'id');
    }

    public function liabilities() {
        return $this->hasMany('App\FilingModel\FormNLiability', 'formn_id', 'id');
    }

    public function expenditures() {
        return $this->hasMany('App\FilingModel\FormNExpenditure', 'formn_id', 'id');
    }

    public function securities() {
        return $this->hasMany('App\FilingModel\FormNSecurity', 'formn_id', 'id');
    }

    public function cash() {
        return $this->hasMany('App\FilingModel\FormNCash', 'formn_id', 'id');
    }

    public function banks() {
        return $this->hasMany('App\FilingModel\FormNBank', 'formn_id', 'id');
    }

    public function lents() {
        return $this->hasMany('App\FilingModel\FormNLent', 'formn_id', 'id');
    }

    public function loans() {
        return $this->hasMany('App\FilingModel\FormNLoan', 'formn_id', 'id');
    }

    public function debts() {
        return $this->hasMany('App\FilingModel\FormNDebt', 'formn_id', 'id');
    }

    public function salaries() {
        return $this->hasMany('App\FilingModel\FormNSalary', 'formn_id', 'id');
    }


}
