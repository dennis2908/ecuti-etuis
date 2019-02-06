<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class FormJ extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'formj';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'tenure_id',
        'address_id',
        'new_address_id',
        'province_office_id',
        'meeting_type_id',
        'resolved_at',
        'justification_id',
        'justification_description',
        'moved_at',
        'address_type_id',
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

    public function new_address() {
        return $this->belongsTo('App\OtherModel\Address', 'new_address_id', 'id');
    }

    public function province_office() {
        return $this->belongsTo('App\MasterModel\MasterProvinceOffice', 'province_office_id', 'id');
    }

    public function meeting_type() {
        return $this->belongsTo('App\MasterModel\MasterMeetingType', 'meeting_type_id', 'id');
    }

    public function justification() {
        return $this->belongsTo('App\MasterModel\MasterJustification', 'justification_id', 'id');
    }

    public function address_type() {
        return $this->belongsTo('App\MasterModel\MasterAddressTyoe', 'address_type_id', 'id');
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
        return $this->morphMany("App\FilingModel\Distribution","filing");
    }

    public function logs() {
        return $this->morphMany('App\LogModel\LogFiling', 'filing');
    }

    public function queries() {
        return $this->morphMany('App\FilingModel\Query', 'filing');
    }
}
