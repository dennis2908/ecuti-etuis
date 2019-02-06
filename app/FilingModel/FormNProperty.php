<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class FormNProperty extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table = 'formn_property';

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
