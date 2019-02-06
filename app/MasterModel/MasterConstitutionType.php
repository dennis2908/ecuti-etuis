<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterConstitutionType extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'master_constitution_type';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'name',
    ];
}
