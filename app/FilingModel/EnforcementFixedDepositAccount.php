<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class EnforcementFixedDepositAccount extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'enforcement_fixed_deposit_account';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'enforcement_id',
        'bank_name',
        'certificate_no',
        'matured_at',
        'total'
    ];

}
