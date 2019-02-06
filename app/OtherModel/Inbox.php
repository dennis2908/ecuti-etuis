<?php

namespace App\OtherModel;

use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inbox';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'sender_user_id',
        'receiver_user_id',
        'subject',
        'message',
        'inbox_status_id',
    ];

    public function sender() {
        return $this->belongsTo('App\User', 'sender_user_id', 'id');
    }

    public function receiver() {
        return $this->belongsTo('App\User', 'receiver_user_id', 'id');
    }

    public function status() {
        return $this->belongsTo('App\MasterModel\MasterInboxStatus', 'inbox_status_id', 'id');
    }
}
