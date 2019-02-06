<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class Appeal extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'appeal';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'user_id',
        'justification',
        'filing_status_id',
    ];

    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function status() {
        return $this->belongsTo('App\MasterModel\MasterFilingStatus', 'filing_status_id', 'id');
    }

    public function references() {
        return $this->morphMany('App\FilingModel\Reference', 'filing');
    }

    public function logs() {
        return $this->morphMany('App\LogModel\LogFiling', 'filing');
    }
}
