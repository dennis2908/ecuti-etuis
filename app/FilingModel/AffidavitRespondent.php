<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class AffidavitRespondent extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table = 'affidavit_respondent';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'affidavit_id',
        'respondent',
    ];

    public function affidavit() {
        return $this->belongsTo('App\FilingModel\Affidavit', 'affidavit_id', 'id');
    }
}
