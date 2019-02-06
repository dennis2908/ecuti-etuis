<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class FormL1Appointed extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'forml1_appointed';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'forml1_id',
        'name',
        'appointment',
        'identification_no',
        'date_of_birth',
        'occupation',
        'appointed_at',
        'address_id',
        'created_by_user_id',
    ];

    public function forml1() {
        return $this->belongsTo('App\FilingModel\FormL1', 'forml1_id', 'id');
    }

    public function address() {
        return $this->belongsTo('App\OtherModel\Address', 'address_id', 'id');
    }

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'id');
    }
}
