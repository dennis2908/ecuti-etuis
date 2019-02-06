<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class FormU extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'formu';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'filing_id',
        'filing_type',
        'tenure_id',
        'user_union_id',
        'address_id',
        'branch_id',
        'setting',
        'voted_at',
        'total_voters',
        'total_slips',
        'total_supporting',
        'total_against',
        'is_supported',
        'is_editable',
        'filing_status_id',
    	'created_by_user_id',
    ];

    public function references() {
        return $this->morphMany('App\FilingModel\Reference', 'filing');
    }

    public function filing() {
        return $this->morphTo();
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

    public function branch() {
        return $this->belongsTo('App\FilingModel\Branch', 'branch_id', 'id');
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

    public function examiners() {
        return $this->hasMany('App\FilingModel\FormUExaminer', 'formu_id', 'id');
    }

    public function arbitrators() {
        return $this->hasMany('App\FilingModel\FormUArbitrator', 'formu_id', 'id');
    }

    public function trustees() {
        return $this->hasMany('App\FilingModel\FormUTrustee', 'formu_id', 'id');
    }
}
