<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class EnforcementAllowance extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'enforcement_allowance';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'filing_id',
        'filing_type',
        'name',
        'value',
    ];

    public function filing() {
        return $this->morphTo();
    }

}
