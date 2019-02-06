<?php

namespace App\OtherModel;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'attachment';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'url',
        'filing_id',
        'filing_type',
        'created_by_user_id',
    ];

    public function filing() {
        return $this->morphTo();
    }

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'id');
    }
}
