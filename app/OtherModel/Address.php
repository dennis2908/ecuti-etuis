<?php

namespace App\OtherModel;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'address';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'address1',
        'address2',
        'address3',
        'postcode',
        'state_id',
        'district_id'
    ];

    public function district() {
        return $this->belongsTo('App\MasterModel\MasterDistrict', 'district_id', 'id');
    }

    public function state() {
        return $this->belongsTo('App\MasterModel\MasterState', 'state_id', 'id');
    }
}
