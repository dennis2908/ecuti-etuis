<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class Lockout extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lockout';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'tenure_id',
        'address_id',
        'employer',
        'employer_address_id',
        'address_lockout',
        'phone_president',
        'phone_secretary',
        'phone_treasurer',
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

    public function employer_address() {
        return $this->belongsTo('App\OtherModel\Address', 'employer_address_id', 'id');
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

    public function attachments() {
        return $this->morphMany('App\OtherModel\Attachment', 'filing');
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

    public function periods() {
        return $this->morphMany('App\FilingModel\Period', 'filing');
    }

    public function formu() {
        return $this->morphOne('App\FilingModel\FormU', 'filing');
    }
}
