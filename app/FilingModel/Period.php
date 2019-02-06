<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table = 'period';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'start_date',
        'end_date',
    ];

    public function filing() {
        return $this->morphTo();
    }
}
