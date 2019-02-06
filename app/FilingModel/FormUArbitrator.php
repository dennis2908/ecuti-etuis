<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class FormUArbitrator extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table = 'formu_arbitrator';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'formu_id',
    	'name',
    ];

    public function formu() {
        return $this->belongsTo('App\FilingModel\FormU', 'formu_id', 'id');
    }
}
