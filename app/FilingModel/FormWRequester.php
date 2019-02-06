<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class FormWRequester extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table = 'formw_requester';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'formw_id',
        'officer_id'
    ];

    public function formw() {
        return $this->belongsTo('App\FilingModel\FormW', 'formw_id', 'id');
    }

    public function officer() {
        return $this->belongsTo('App\FilingModel\Officer', 'officer_id', 'id');
    }
}
