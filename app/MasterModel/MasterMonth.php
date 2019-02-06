<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterMonth extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table = 'master_month';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'name',
        'code',
    ];
}
