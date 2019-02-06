<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class FormBB extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'formbb';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tenure_id',
    	'user_federation_id',
        'address_id',
        'established_at',
        'federation_type_id',
        'sector_id',
        'sector_category_id',
        'sector_category',
        'is_national',
        'meeting_type_id',
        'resolved_at',
        'filing_status_id',
        'applied_at',
        'is_editable',
        'created_by_user_id'
    ];

    public function references() {
        return $this->morphMany('App\FilingModel\Reference', 'filing');
    }

    public function tenure() {
        return $this->belongsTo('App\FilingModel\Tenure', 'tenure_id', 'id');
    }

    public function federation() {
        return $this->belongsTo('App\UserFederation', 'user_federation_id', 'id');
    }

    public function address() {
        return $this->belongsTo('App\OtherModel\Address', 'address_id', 'id');
    }

    public function federation_type() {
        return $this->belongsTo('App\MasterModel\MasterFederationType', 'federation_type_id', 'id');
    }

    public function meeting_type() {
        return $this->belongsTo('App\MasterModel\MasterMeetingType', 'meeting_type_id', 'id');
    }

    public function sector() {
        return $this->belongsTo('App\MasterModel\MasterSector', 'sector_id', 'id');
    }

    public function category() {
        return $this->belongsTo('App\MasterModel\MasterSectorCategory', 'sector_category_id', 'id');
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

    public function constitutions() {
        return $this->morphMany('App\FilingModel\Constitution', 'entity');
    }

    public function logs() {
        return $this->morphMany('App\LogModel\LogFiling', 'filing');
    }

    public function queries() {
        return $this->morphMany('App\FilingModel\Query', 'filing');
    }

    public function bb3() {
        return $this->hasOne('App\OtherModel\FormBB3', 'formbb_id', 'id');
    }
}
