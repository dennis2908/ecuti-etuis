<?php

namespace App\OtherModel;

use Illuminate\Database\Eloquent\Model;

class FormBB3 extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'formbb3';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'formbb_id',
        'entrance_fee',
        'yearly_fee',
        'convention_yearly',
        'first_member',
        'next_member',
        'max_savings',
        'max_expenses',
        'created_by_user_id',
    ];

    public function formbb() {
        return $this->belongsTo('App\FilingModel\FormBB', 'formbb_id', 'id');
    }

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'id');
    }
}
