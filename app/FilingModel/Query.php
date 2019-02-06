<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'query';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'log_filing_id',
        'filing_id',
        'filing_type',
        'content',
        'created_by_user_id',
    ];

    public function filing() {
        return $this->morphTo();
    }

    public function log() {
        return $this->belongsTo('App\LogModel\LogFiling', 'log_filing_id', 'id');
    }

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'id');
    }
}
