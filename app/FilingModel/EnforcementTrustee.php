<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class EnforcementTrustee extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'enforcement_trustee';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'enforcement_id',
        'identification_no',
        'name',
        'appointed_at',
        'date_of_birth'
    ];

    public function enforcement() {
        return $this->belongsTo('App\FilingModel\Enforcement', 'enforcement_id', 'id');
    }

}
