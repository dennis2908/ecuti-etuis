<?php

namespace App\OtherModel;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'holiday';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'name',
        'holiday_type_id',
        'start_date',
        'duration',
		'user_id',
        'created_by_user_id',
    ];

    public function holiday_type() {
        return $this->belongsTo('App\MasterModel\MasterHolidayType', 'holiday_type_id', 'id');
    }

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'id');
    }

    public function states() {
        return $this->hasMany('App\OtherModel\HolidayState', 'holiday_id', 'id');
    }
}
