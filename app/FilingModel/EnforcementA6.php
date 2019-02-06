<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class EnforcementA6 extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'enforcement_a6';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'enforcement_id',
        'company_name',
        'duration',
    ];

    public function enforcement() {
        return $this->belongsTo('App\FilingModel\Enforcement', 'enforcement_id', 'id');
    }

}
