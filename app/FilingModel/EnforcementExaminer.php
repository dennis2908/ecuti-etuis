<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class EnforcementExaminer extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'enforcement_examiner';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'enforcement_id',
        'identification_no',
        'name',
        'appointed_at'
    ];

    public function enforcement() {
        return $this->belongsTo('App\FilingModel\Enforcement', 'enforcement_id', 'id');
    }

}
