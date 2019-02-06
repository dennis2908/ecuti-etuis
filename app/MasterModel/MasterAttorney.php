<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterAttorney extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table = 'master_attorney';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'name',
        'address_id',    
    ];

    public function address() {
        return $this->belongsTo('App\OtherModel\Address', 'address_id', 'id');
    }
}
