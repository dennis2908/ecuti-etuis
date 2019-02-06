<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class ProsecutionPDW13Accused extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table = 'prosecution_pdw13_accused';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'prosecution_pdw13_id',
        'accused',
        'identification_no',
    ];

    public function pdw13() {
        return $this->belongsTo('App\FilingModel\ProsecutionPDW13', 'prosecution_pdw13_id', 'id');
    }

}
