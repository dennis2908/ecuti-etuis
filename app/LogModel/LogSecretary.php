<?php

namespace App\LogModel;

use Illuminate\Database\Eloquent\Model;

class LogSecretary extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'log_secretary';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'entity_id',
        'entity_type',
        'secretary_user_id',
        'date_start',
        'date_end',
    ];

    public function module() {
        return $this->belongsTo('App\User', 'secretary_user_id', 'id');
    }

    public function entity() {
        return $this->morphTo();
    }

}
