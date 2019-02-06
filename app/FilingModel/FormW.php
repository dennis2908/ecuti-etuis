<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class FormW extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'formw';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'tenure_id',
        'registration_no',
        'address_id',
        'consultant_name',
        'address',
        'phone',
        'fax',
        'email',
        'resolved_at',
        'meeting_type_id',
        'applied_at',
        'is_verify',
        'is_editable',
        'filing_status_id',
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

    public function meeting_type() {
        return $this->belongsTo('App\MasterModel\MasterMeetingType', 'meeting_type_id', 'id');
    }

    public function status() {
        return $this->belongsTo('App\MasterModel\MasterFilingStatus', 'filing_status_id', 'id');
    }

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'id');
    }

    public function logs() {
        return $this->morphMany('App\LogModel\LogFiling', 'filing');
    }

    public function letters() {
        return $this->morphMany('App\OtherModel\Letter','filing');
    }

    public function distributions(){
        return $this->morphMany("App\FilingModel\Distribution","filing");
    }

    public function queries() {
        return $this->morphMany('App\FilingModel\Query', 'filing');
    }

    public function purposes() {
        return $this->morphMany('App\FilingModel\ConsultancyPurpose', 'filing');
    }

    public function requesters() {
        return $this->hasMany('App\FilingModel\FormWRequester', 'formw_id', 'id');
    }

    public function officers() {
        return $this->morphMany('App\FilingModel\Officer', 'filing');
    }
}
