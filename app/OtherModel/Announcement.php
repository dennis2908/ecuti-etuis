<?php

namespace App\OtherModel;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'announcement';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'title',
        'description',
        'announcement_type_id',
        'date_start',
        'date_end',
        'created_by_user_id'
    ];

    public function type() {
        return $this->belongsTo('App\MasterModel\MasterAnnouncementType', 'announcement_type_id', 'id');
    }

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'id');
    }

    public function targets() {
        return $this->hasMany('App\OtherModel\AnnouncementTarget', 'announcement_id', 'id');
    }
}
