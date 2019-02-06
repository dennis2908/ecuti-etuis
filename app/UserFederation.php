<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserFederation extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_federation';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'registration_no',
        'registered_at',
        'province_office_id',
        'industry_type_id',
    ];

    public function user() {
        return $this->morphOne('App\User', 'entity');
    }

    public function branches() {
        return $this->hasMany('App\FilingModel\Branch', 'created_at', 'id');
    }

    public function province_office() {
        return $this->belongsTo('App\MasterModel\MasterProvinceOffice', 'province_office_id', 'id');
    }

    public function industry_type() {
        return $this->belongsTo('App\MasterModel\MasterIndustryType', 'industry_type_id', 'id');
    }

    public function unions() {
        return $this->hasMany('App\UserUnion', 'user_federation_id', 'id');
    }

    public function constitutions() {
        return $this->morphMany("App\FilingModel\Constitution","entity");
    }

    public function formbb() {
        return $this->hasOne('App\FilingModel\FormBB', 'user_federation_id', 'id');
    }

    public function addresses() {
        return $this->morphMany('App\UserAddress','entity');
    }

    public function tenures() {
        return $this->morphMany('App\FilingModel\Tenure', 'entity');
    }

    public function references() {
        return $this->morphMany('App\FilingModel\Reference', 'entity');
    }
}
