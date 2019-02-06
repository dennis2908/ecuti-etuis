<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class Requester extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'requester';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'name',
        'filing_id',
        'filing_type',
        'identification_no',
        'occupation',
        'address_id',
        'created_by_user_id',
    ];

    public function filing() {
        return $this->morphTo();
    }

    public function address() {
        return $this->belongsTo('App\OtherModel\Address', 'address_id', 'id');
    }

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'id');
    }
}
