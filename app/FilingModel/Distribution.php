<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class Distribution extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'distribution';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'filing_id',
        'filing_type',
        'filing_status_id',
        'assigned_to_user_id',
    ];

    public function filing() {
        return $this->morphTo();
    }

    public function filing_status() {
        return $this->belongsTo('App\MasterModel\MasterFilingStatus', 'filing_status_id', 'id');
    }

    public function assigned_to() {
        return $this->belongsTo('App\User', 'assigned_to_user_id', 'id');
    }
}
