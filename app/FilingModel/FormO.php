<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class FormO extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'formo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tenure_id',
    	'user_union_id',
        'address_id',
        'federation_name',
        'resolved_at',
        'meeting_type_id',
        'filing_status_id',
        'is_editable',
        'created_by_user_id'
    ];

    public function references() {
        return $this->morphMany('App\FilingModel\Reference', 'filing');
    }

    public function tenure() {
        return $this->belongsTo('App\FilingModel\Tenure', 'tenure_id', 'id');
    }

    public function union() {
        return $this->belongsTo('App\UserUnion', 'user_union_id', 'id');
    }

    public function unions() {
        return $this->hasMany('App\FilingModel\FormOUnion', 'formo_id', 'id');
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

    public function distributions(){
        return $this->morphMany("App\FilingModel\Distribution","filing");
    }

    public function logs() {
        return $this->morphMany('App\LogModel\LogFiling', 'filing');
    }
}
