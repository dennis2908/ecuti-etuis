<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class FormNLiability extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table = 'formn_liability';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'formn_id',
    	'name',
        'total',
    ];

    public function formn() {
        return $this->belongsTo('App\FilingModel\FormN', 'formn_id', 'id');
    }
}
