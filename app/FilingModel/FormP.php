<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class FormP extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'formp';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'formpq_id',
    	'registration_no',
        'address_id',
        'user_federation_id',
        'resolved_at',
        'meeting_type_id',
        'secretary_user_id',
        'filing_status_id',
        'applied_at',
        'created_by_user_id',
    ];

    public function references() {
        return $this->morphMany('App\FilingModel\Reference', 'filing');
    }

    public function formpq() {
        return $this->belongsTo('App\FilingModel\FormPQ', 'formpq_id', 'id');
    }

    public function federation() {
        return $this->belongsTo('App\UserFederation', 'user_federation_id', 'id');
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

    public function distributions(){
        return $this->morphMany("App\FilingModel\Distribution","filing");
    }

    public function logs() {
        return $this->morphMany('App\LogModel\LogFiling', 'filing');
    }
}
