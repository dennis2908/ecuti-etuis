<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterCourt extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table = 'master_court';
    
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
