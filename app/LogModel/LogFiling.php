<?php

namespace App\LogModel;

use Illuminate\Database\Eloquent\Model;

class LogFiling extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'log_filing';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'module_id',
        'activity_type_id',
        'filing_id',
        'filing_type',
        'filing_status_id',
        'data',
        'created_by_user_id',
        'role_id',
    ];

    public function module() {
        return $this->belongsTo('App\MasterModel\MasterModule', 'module_id', 'id');
    }

    public function status() {
        return $this->belongsTo('App\MasterModel\MasterFilingStatus', 'filing_status_id', 'id');
    }

    public function activity_type() {
        return $this->belongsTo('App\MasterModel\MasterActivityType', 'activity_type_id', 'id');
    }

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'id');
    }

    public function role() {
        return $this->belongsTo('App\Role', 'role_id', 'id');
    }

    public function filing() {
        return $this->morphTo();
    }

    public function queries() {
        return $this->hasMany('App\FilingModel\Query', 'log_filing_id', 'id');
    }
}
