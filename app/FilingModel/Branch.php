<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'branch';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'name',
        'user_union_id',
        'address_id',
        'secretary_name',
        'secretary_email',
        'secretary_phone',
        'total_member',
        'established_at',
        'meeting_at'
    ];

    public function union() {
        return $this->belongsTo('App\UserUnion', 'user_union_id', 'id');
    }

    public function address() {
        return $this->belongsTo('App\OtherModel\Address', 'address_id', 'id');
    }
}
