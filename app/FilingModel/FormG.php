<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class FormG extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'formg';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'tenure_id',
        'address_id',
        'name',
        'justification',
        'meeting_type_id',
        'resolved_at',
        'registration_no',
        'secretary_user_id',
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

    public function meeting_type() {
        return $this->belongsTo('App\MasterModel\MasterMeetingType', 'meeting_type_id', 'id');
    }

    public function secretary() {
        return $this->belongsTo('App\User', 'secretary_user_id', 'id');
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
        return $this->morphMany('App\FilingModel\Distribution','filing');
    }

    public function logs() {
        return $this->morphMany('App\LogModel\LogFiling', 'filing');
    }

    public function queries() {
        return $this->morphMany('App\FilingModel\Query', 'filing');
    }

    public function members() {
        return $this->hasMany('App\FilingModel\FormGMember', 'formg_id', 'id');
    }
}
