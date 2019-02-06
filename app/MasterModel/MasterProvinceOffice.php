<?php

namespace App\MasterModel;

use App\UserStaff;
use Illuminate\Database\Eloquent\Model;

class MasterProvinceOffice extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table = 'master_province_office';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'name',
        'address_id',
        'phone',
        'fax',
        'email',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['pw','kpks','pkpg'];

    public function address() {
        return $this->belongsTo('App\OtherModel\Address', 'address_id', 'id');
    }

    public function getPwAttribute() {
        return UserStaff::where('role_id', 8)->where('province_office_id', $this->id)->whereHas('user', function($user) {
            return $user->where('user_status_id', 1);
        })
        ->get()
        ->last()->user;
    }

    public function getKpksAttribute() {
        return UserStaff::where('role_id', 17)->whereHas('user', function($user) {
            return $user->where('user_status_id', 1);
        })
        ->get()
        ->last()->user;
    }

    public function getPkpgAttribute() {
        return UserStaff::where('role_id', 12)->whereHas('user', function($user) {
            return $user->where('user_status_id', 1);
        })
        ->get()
        ->last()->user;
    }
}
