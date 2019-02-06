<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class EnforcementFederation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'enforcement_federation';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'enforcement_id',
        'user_federation_id',
    ];

    public function federation() {
        return $this->belongsTo('App\UserFederation', 'user_federation_id', 'id');
    }

}
