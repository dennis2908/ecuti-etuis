<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class ConsultancyPurpose extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'consultancy_purpose';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'filing_id',
        'filing_type',
        'purpose'
    ];

    public function filing() {
        return $this->morphTo();
    }
}
