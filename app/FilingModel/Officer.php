<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'officer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [  
        'filing_id',
        'filing_type',
        'tenure_id',
        'name',
        'designation_id',
        'held_at',
        'age',
        'occupation',
        'nationality_country_id',
        'identification_no',
        'address_id',
        'previous_designation_id',
        'conviction',
        'date_of_birth',
        'left_at',
        'created_by_user_id',
    ];

    public function filing() {
        return $this->morphTo();
    }

    public function tenure() {
        return $this->belongsTo('App\FilingModel\Tenure', 'tenure_id', 'id');
    }

    public function designation() {
        return $this->belongsTo('App\MasterModel\MasterDesignation', 'designation_id', 'id');
    }

    public function nationality() {
        return $this->belongsTo('App\MasterModel\MasterCountry', 'nationality_country_id', 'id');
    }

    public function previous_designation() {
        return $this->belongsTo('App\MasterModel\MasterDesignation', 'previous_designation_id', 'id');
    }

    public function address() {
        return $this->belongsTo('App\OtherModel\Address', 'address_id', 'id');
    }

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'id');
    }

    public function formw_requester() {
        return $this->hasMany('App\FilingModel\FormWRequester', 'officer_id', 'id');
    }

    public function exception_pp30_officer() {
        return $this->hasMany('App\FilingModel\ExceptionPP30Officer', 'officer_id', 'id');
    }

}
