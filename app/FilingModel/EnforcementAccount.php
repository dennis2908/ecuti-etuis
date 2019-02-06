<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class EnforcementAccount extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'enforcement_account';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'enforcement_id',
        'bank_name',
        'account_no',
        'account_type_id',
    ];

}
