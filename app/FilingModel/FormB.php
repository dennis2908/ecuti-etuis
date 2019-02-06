<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class FormB extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'formb';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tenure_id',
    	'user_union_id',
        'address_id',
        'has_branch',
        'union_type_id',
        'sector_id',
        'sector_category_id',
        'sector_category',
        'is_national',
        'total_member',
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

    public function union() {
        return $this->belongsTo('App\UserUnion', 'user_union_id', 'id');
    }

    public function address() {
        return $this->belongsTo('App\OtherModel\Address', 'address_id', 'id');
    }

    public function union_type() {
        return $this->belongsTo('App\MasterModel\MasterUnionType', 'union_type_id', 'id');
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

    public function requesters() {
        return $this->morphMany('App\FilingModel\Requester', 'filing');
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

    public function b3() {
        return $this->hasOne('App\OtherModel\FormB3', 'formb_id', 'id');
    }

    public function b4() {
        return $this->hasOne('App\OtherModel\FormB4', 'formb_id', 'id');
    }
}
