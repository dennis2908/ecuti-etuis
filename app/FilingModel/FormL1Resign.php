<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class FormL1Resign extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table = 'forml1_resign';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'forml1_id',
        'worker_id',
        'left_at',
    ];

    public function worker() {
        return $this->belongsTo('App\FilingModel\Worker', 'worker_id', 'id');
    }

    public function forml1() {
        return $this->belongsTo('App\FilingModel\FormL1', 'forml1_id', 'id');
    }
}
