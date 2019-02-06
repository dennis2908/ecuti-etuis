<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class EnforcementAuditor extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'enforcement_auditor';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'enforcement_id',
        'designation',
        'name',
    ];
}
