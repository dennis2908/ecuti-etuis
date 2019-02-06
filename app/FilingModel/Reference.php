<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table = 'reference';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'filing_id',
        'filing_type',
        'reference_no',
        'reference_type_id',
        'module_id',
    ];

    public function filing() {
        return $this->morphTo();
    }

    public function type() {
        return $this->belongsTo('App\MasterModel\MasterReferenceType', 'reference_type_id', 'id');
    }

    public function module() {
        return $this->belongsTo('App\MasterModel\MasterModule', 'module_id', 'id');
    }
}
