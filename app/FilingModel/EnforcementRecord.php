<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class EnforcementRecord extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'enforcement_record';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'enforcement_id',
        'inspection_at',
        'duration',
    ];

}
