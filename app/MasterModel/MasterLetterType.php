<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterLetterType extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table = 'master_letter_type';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'name',
        'module_id',
        'template_name',
    ];

    public function module() {
        return $this->belongsTo('App\MasterModel\MasterModule', 'module_id', 'id');
    }
}
