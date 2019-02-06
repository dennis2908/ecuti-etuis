<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasRoles;
    use Notifiable;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'entity_id',
        'entity_type',
        'name',
        'username',
        'password',
        'email',
        'phone',
        'picture_url',
        'user_type_id',
        'user_status_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function isOnline() {
        return \Cache::has('user-is-online-' . $this->id);
    }

    public function entity() {
        return $this->morphTo();
    }

    public function entity_staff() {
        return $this->belongsTo('App\UserStaff', 'entity_id', 'id');
    }

    public function type() {
        return $this->belongsTo('App\MasterModel\MasterUserType', 'user_type_id', 'id');
    }

    public function status() {
        return $this->belongsTo('App\MasterModel\MasterUserStatus', 'user_status_id', 'id');
    }

    public function appeal() {
        return $this->hasOne('App\FilingModel\Appeal', 'user_id', 'id');
    }

    public function assignments() {
        return $this->hasMany('App\FilingModel\Distribution', 'assigned_to_user_id', 'id');
    }

    public function logs() {
        return $this->hasMany('App\LogModel\LogSystem', 'created_by_user_id', 'id');
    }

    public function inboxes() {
        return $this->hasMany('App\OtherModel\Inbox', 'receiver_user_id', 'id');
    }
}
