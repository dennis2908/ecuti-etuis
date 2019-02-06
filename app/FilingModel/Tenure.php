<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class Tenure extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tenure';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'entity_id',
        'entity_type',
        'meeting_type_id',
        'meeting_at',
        'duration',
        'start_year',
        'end_year',
    ];

    public function entity() {
        return $this->morphTo();
    }

    public function meeting_type() {
         return $this->belongsTo('App\MasterModel\MasterMeetingType', 'meeting_type_id', 'id');
    }

    public function formjl1() {
         return $this->hasMany('App\FilingModel\FormJL1', 'tenure_id', 'id');
    }

    public function officers() {
         return $this->hasMany('App\FilingModel\Officer', 'tenure_id', 'id');
    }

    public function workers() {
         return $this->hasMany('App\FilingModel\Worker', 'tenure_id', 'id');
    }

    public function formlu() {
         return $this->hasOne('App\FilingModel\FormL', 'tenure_id', 'id')->has('formu');
    }

    public function forml() {
         return $this->hasOne('App\FilingModel\FormL', 'tenure_id', 'id')->doesntHave('formu');
    }

    public function forml1() {
         return $this->hasOne('App\FilingModel\FormL1', 'tenure_id', 'id');
    }
}
