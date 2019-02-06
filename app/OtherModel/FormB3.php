<?php

namespace App\OtherModel;

use Illuminate\Database\Eloquent\Model;

class FormB3 extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'formb3';

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
        'meeting_yearly',
        'total_ajk',
        'ajk_yearly',
        'max_savings',
        'max_expenses',
        'created_by_user_id',
    ];

    public function formb() {
        return $this->belongsTo('App\FilingModel\FormB', 'formb_id', 'id');
    }

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'id');
    }
}
