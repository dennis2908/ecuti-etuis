<?php

namespace App\OtherModel;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notification';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'message',
        'created_by_user_id',
    ];
    
    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'id');
    }
}
