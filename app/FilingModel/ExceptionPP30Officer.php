<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class ExceptionPP30Officer extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table = 'exception_pp30_officer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'exception_pp30_id',
        'officer_id',
    ];

    public function exception() {
        return $this->belongsTo('App\FilingModel\ExceptionPP30', 'exception_pp30_id', 'id');
    }

    public function officer() {
        return $this->belongsTo('App\FilingModel\Officer', 'officer_id', 'id');
    }
}
