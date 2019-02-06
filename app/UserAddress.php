<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_address';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'entity_id',
        'entity_type',
        'address_id',
    ];

    public function entity() {
        return $this->morphTo();
    }

    public function address() {
         return $this->belongsTo('App\OtherModel\Address', 'address_id', 'id');
    }
}
