<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class EnforcementA1 extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'enforcement_a1';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'enforcement_id',
        'designation_id',
        'name',
        'phone',
        'email',
        'office_location',
        'grade',
        'address_id'
    ];

    public function enforcement() {
        return $this->belongsTo('App\FilingModel\Enforcement', 'enforcement_id', 'id');
    }

    public function designation() {
        return $this->belongsTo('App\MasterModel\MasterDesignation', 'designation_id', 'id');
    }

    public function address() {
        return $this->belongsTo('App\OtherModel\Address', 'address_id', 'id');
    }

}
