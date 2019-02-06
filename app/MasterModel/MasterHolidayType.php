<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterHolidayType extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table = 'master_holiday_type';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'name',
        'start_date',
        'duration'
    ];
}
