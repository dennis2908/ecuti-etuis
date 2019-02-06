<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class Enforcement extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'enforcement';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'entity_type',
        'entity_id',
        'branch_id',
        'district_id',
        'state_id',
        'start_date',
        'end_date',
        'applied_at',
        'filing_status_id',
        'is_editable',
        'created_by_user_id',
    ];

    public function references() {
        return $this->morphMany('App\FilingModel\Reference', 'filing');
    }

    public function entity() {
        return $this->morphTo();
    }

    public function branch() {
        return $this->belongsTo('App\FilingModel\Branch', 'branch_id', 'id');
    }

    public function district() {
        return $this->belongsTo('App\MasterModel\MasterDistrict', 'district_id', 'id');
    }

    public function state() {
        return $this->belongsTo('App\MasterModel\MasterState', 'state_id', 'id');
    }

    public function status() {
        return $this->belongsTo('App\MasterModel\MasterFilingStatus', 'filing_status_id', 'id');
    }

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'id');
    }

    public function letters() {
        return $this->morphMany('App\OtherModel\Letter','filing');
    }

    public function distributions(){
        return $this->morphMany('App\FilingModel\Distribution', 'filing');
    }

    public function logs() {
        return $this->morphMany('App\LogModel\LogFiling', 'filing');
    }

    public function queries() {
        return $this->morphMany('App\FilingModel\Query', 'filing');
    }

    public function pbp2(){
        return $this->hasOne('App\FilingModel\EnforcementPBP2', 'enforcement_id', 'id');
    }

    public function a1(){
        return $this->hasMany('App\FilingModel\EnforcementA1', 'enforcement_id', 'id');
    }

    public function a2(){
        return $this->hasMany('App\FilingModel\EnforcementA2', 'enforcement_id', 'id');
    }

    public function a3(){
        return $this->hasMany('App\FilingModel\EnforcementA3', 'enforcement_id', 'id');
    }

    public function a4(){
        return $this->hasMany('App\FilingModel\EnforcementA4', 'enforcement_id', 'id');
    }

    public function a5(){
        return $this->hasMany('App\FilingModel\EnforcementA5', 'enforcement_id', 'id');
    }

    public function a6(){
        return $this->hasMany('App\FilingModel\EnforcementA6', 'enforcement_id', 'id');
    }

    public function b1(){
        return $this->hasMany('App\FilingModel\EnforcementB1', 'enforcement_id', 'id');
    }

    public function c1(){
        return $this->hasOne('App\FilingModel\EnforcementC1', 'enforcement_id', 'id');
    }

    public function d1(){
        return $this->hasMany('App\FilingModel\EnforcementD1', 'enforcement_id', 'id');
    }

    public function auditors(){
        return $this->hasMany('App\FilingModel\EnforcementAuditor', 'enforcement_id', 'id');
    }

    public function accounts(){
        return $this->hasMany('App\FilingModel\EnforcementAccount', 'enforcement_id', 'id');
    }

    public function allowances(){
        return $this->hasMany('App\FilingModel\EnforcementAllowance', 'enforcement_id', 'id');
    }

    public function arbitrators(){
        return $this->hasMany('App\FilingModel\EnforcementArbitrator', 'enforcement_id', 'id');
    }

    public function examiners(){
        return $this->hasMany('App\FilingModel\EnforcementExaminer', 'enforcement_id', 'id');
    }

    public function meetings(){
        return $this->hasMany('App\FilingModel\EnforcementMeeting', 'enforcement_id', 'id');
    }

    public function notices(){
        return $this->hasMany('App\FilingModel\EnforcementNotice', 'enforcement_id', 'id');
    }

    public function records(){
        return $this->hasMany('App\FilingModel\EnforcementRecord', 'enforcement_id', 'id');
    }

    public function trustees(){
        return $this->hasMany('App\FilingModel\EnforcementTrustee', 'enforcement_id', 'id');
    }

    public function external_consultants(){
        return $this->hasMany('App\FilingModel\EnforcementExternalConsultant', 'enforcement_id', 'id');
    }

    public function internal_consultants(){
        return $this->hasMany('App\FilingModel\EnforcementInternalConsultant', 'enforcement_id', 'id');
    }

    public function federations(){
        return $this->hasMany('App\FilingModel\EnforcementFederation', 'enforcement_id', 'id');
    }

    public function fd_accounts(){
        return $this->hasMany('App\FilingModel\EnforcementFixedDepositAccount', 'enforcement_id', 'id');
    }

    public function incentives(){
        return $this->hasMany('App\FilingModel\EnforcementIncentives', 'enforcement_id', 'id');
    }
}
