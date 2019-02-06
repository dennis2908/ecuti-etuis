<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class EligibilityIssue extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'eligibility_issue';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reference_no',
        'entity_type',
        'entity_id',
        'filing_status_id',
        'is_editable',
        'created_by_user_id',
    ];

    public function entity() {
        return $this->morphTo();
    }

    public function forma() {
        return $this->hasOne('App\FilingModel\FormA', 'eligibility_issue_id', 'id');
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

    public function references() {
        return $this->morphMany('App\FilingModel\Reference', 'filing');
    }
}
