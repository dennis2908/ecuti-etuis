<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class ExceptionPP30 extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'exception_pp30';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'tenure_id',
        'address_id',
        'requested_at',
        'requested_tenure_id',
        'total_citizen',
        'total_non_citizen',
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

    public function requested_tenure() {
        return $this->belongsTo('App\FilingModel\Tenure', 'requested_tenure_id', 'id');
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

    public function officers() {
        return $this->hasMany('App\FilingModel\ExceptionPP30Officer', 'exception_pp30_id', 'id');
    }

}
