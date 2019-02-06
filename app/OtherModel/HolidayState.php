<?php

namespace App\OtherModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class HolidayState extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table = 'holiday_state';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'holiday_id',
        'state_id',
    ];

    public function holiday() {
        return $this->belongsTo('App\OtherModel\Holiday', 'holiday_id', 'id');
    }

    public function state() {
        return $this->belongsTo('App\MasterModel\MasterState', 'state_id', 'id');
    }
}
