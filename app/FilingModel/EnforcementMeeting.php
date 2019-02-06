<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class EnforcementMeeting extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'enforcement_meeting';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'enforcement_id',
        'total_meeting',
        'meeting_at',
    ];

}
