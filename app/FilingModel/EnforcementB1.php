<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class EnforcementB1 extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'enforcement_b1';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'enforcement_id',
        'asset_type',
        'year_obtained',
        'current_value',
        'location',
    ];

    public function enforcement() {
        return $this->belongsTo('App\FilingModel\Enforcement', 'enforcement_id', 'id');
    }

}
