<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class EnforcementC1 extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'enforcement_c1';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'enforcement_id',
        'start_year',
        'end_year',
        'cash_at_bank',
        'cash_at_hand',
        'entrance_fee',
        'monthly_fee',
        'union_office',
        'volunteer_fund',
        'special_collection',
        'bank_interest',
        'officer_allowance',
        'post_shipping',
        'phone',
        'stationary',
        'wage',
        'meeting_expense',
        'deposit_payment',
        'social_payment',
        'tax',
        'rental',
        'electric_bill',
        'welfare_aid',
        'union_payment',
        'seminar_course',
        'cash_at',
        'total_at_hand',
        'bank_at',
        'total_at_hand',
        'total_income',
        'total_liability'
    ];

    public function enforcement() {
        return $this->belongsTo('App\FilingModel\Enforcement', 'enforcement_id', 'id');
    }

}
