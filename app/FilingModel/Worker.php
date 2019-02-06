<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'worker';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'filing_id',
        'filing_type',
        'tenure_id',
        'name',
        'appointment',
        'identification_no',
        'date_of_birth',
        'occupation',
        'appointed_at',
        'left_at',
        'address_id',
    	'created_by_user_id',
    ];

    public function filing() {
        return $this->morphTo();
    }

    public function tenure() {
        return $this->belongsTo('App\FilingModel\Tenure', 'tenure_id', 'id');
    }

    public function address() {
        return $this->belongsTo('App\OtherModel\Address', 'address_id', 'id');
    }

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'id');
    }

}
