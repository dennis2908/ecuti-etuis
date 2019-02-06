<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserStaff extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_staff';

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
        'role_id',
        'province_office_id',
		'atasan_role'
    ];

    public function user() {
        return $this->morphOne('App\User', 'entity');
    }

    public function province_office() {
        return $this->belongsTo('App\MasterModel\MasterProvinceOffice', 'province_office_id', 'id');
    }

    public function role() {
        return $this->belongsTo('App\Role', 'role_id', 'id');
    }
}
