<?php

namespace App\OtherModel;

use Illuminate\Database\Eloquent\Model;

class FormB4 extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'formb4';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'formb_id',
        'membership_target',
        'paid_by',
        'entrance_fee',
        'monthly_fee',
        'workplace',
        'fixed_fee',
        'percentage_fee',
        'conference_yearly',
        'rep_yearly',
        'meeting_yearly',
        'first_member',
        'next_member',
        'max_rep',
        'max_savings',
        'max_expenses',
        'min_member',
        'low_member',
        'total_ajk',
        'ajk_yearly',
        'branch_max_savings',
        'branch_max_expenses',
        'created_by_user_id',
    ];

    public function formb() {
        return $this->belongsTo('App\FilingModel\FormB', 'formb_id', 'id');
    }

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'id');
    }
}
