<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class FormJL1FormN extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table = 'formjl1_formn';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'formjl1_id',
        'formn_id',
    ];

    public function formjl1() {
        return $this->belongsTo('App\FilingModel\FormJL1', 'formjl1_id', 'id');
    }

    public function formn() {
        return $this->belongsTo('App\FilingModel\FormN', 'formn_id', 'id');
    }

}
