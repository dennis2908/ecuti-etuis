<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class EnforcementNotice extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'enforcement_notice';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'enforcement_id',
        'notice',
    ];

}
