<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class Ectr4uFederation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ectr4u_federation';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ectr4u_id',
        'user_federation_id',
    ];

    public function ectr4u() {
        return $this->belongsTo('App\FilingModel\Ectr4u', 'ectr4u_id', 'id');
    }

    public function federation() {
        return $this->belongsTo('App\UserFederation', 'user_federation_id', 'id');
    }
}
