<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterConstitutionTemplate extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'master_constitution_template';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
    	'content',
        'parent_constitution_template_id',
        'below_constitution_template_id',
        'constitution_type_id',
    ];

    public function parent() {
         return $this->belongsTo('App\MasterModel\MasterConstitutionTemplate', 'parent_constitution_template_id', 'id');
    }

    public function type() {
         return $this->belongsTo('App\MasterModel\MasterConstitutionType', 'constitution_type_id', 'id');
    }
}
