<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class ExceptionPP68 extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'exception_pp68';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'tenure_id',
        'address_id',

        'is_fee_excepted',
        'justification_fee',
        'is_fee_approved',
        'justification_fee_approved',

        'is_receipt_excepted',
        'justification_receipt',
        'is_receipt_approved',
        'justification_receipt_approved',

        'is_computer_excepted',
        'justification_computer',
        'is_computer_approved',
        'justification_computer_approved',

        'is_system_excepted',
        'justification_system',
        'is_system_approved',
        'justification_system_approved',

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
}
