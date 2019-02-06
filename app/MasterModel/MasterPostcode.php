<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterPostcode extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table = 'master_postcode';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'code',
    	'district_id',
    ];

    public function district() {
        return $this->belongsTo('App\MasterModel\MasterDistrict', 'district_id', 'id');
    }
}
