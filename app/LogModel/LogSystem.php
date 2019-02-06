<?php

namespace App\LogModel;

use Illuminate\Database\Eloquent\Model;

class LogSystem extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'log_system';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'module_id',
        'activity_type_id',
        'description',
        'data_old',
        'data_new',
        'url',
        'method',
        'ip_address',
        'created_by_user_id',
    ];

    public function module() {
        return $this->belongsTo('App\MasterModel\MasterModule', 'module_id', 'id');
    }

    public function activity_type() {
        return $this->belongsTo('App\MasterModel\MasterActivityType', 'activity_type_id', 'id');
    }

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'id');
    }
}
