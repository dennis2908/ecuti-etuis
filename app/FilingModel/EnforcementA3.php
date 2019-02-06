<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class EnforcementA3 extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'enforcement_a3';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'enforcement_id',
        'designation_id',
    ];

    public function enforcement() {
        return $this->belongsTo('App\FilingModel\Enforcement', 'enforcement_id', 'id');
    }

    public function designation() {
        return $this->belongsTo('App\MasterModel\MasterDesignation', 'designation_id', 'id');
    }

    public function incentives() {
        return $this->morphMany('App\FilingModel\EnforcementIncentive', 'filing');
   }

   public function allowances() {
        return $this->morphMany('App\FilingModel\EnforcementAllowance', 'filing');
   }

}
