<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterState extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table = 'master_state';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'name',
        'is_friday_weekend',
        'province_office_id',
    ];

    public function districts() {
        return $this->hasMany('App\MasterModel\MasterDistrict', 'state_id', 'id');
    }
}
