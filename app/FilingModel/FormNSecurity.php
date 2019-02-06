<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class FormNSecurity extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table = 'formn_security';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'formn_id',
    	'description',
        'market_value',
        'cash',
        'external_value',
        'cost_value',
        'created_by_user_id',
    ];

    public function formn() {
        return $this->belongsTo('App\FilingModel\FormN', 'formn_id', 'id');
    }

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'id');
    }
}
