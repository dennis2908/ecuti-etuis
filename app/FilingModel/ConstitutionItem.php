<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConstitutionItem extends Model
{
    use SoftDeletes;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'constitution_item';

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
        'constitution_id',
        'code',
    	'content',
        'parent_constitution_item_id',
        'below_constitution_item_id',
        'constitution_template_id',
    ];

    public function constitution() {
         return $this->belongsTo('App\FilingModel\Constitution', 'constitution_id', 'id');
    }

    public function parent() {
         return $this->belongsTo('App\FilingModel\ConstitutionItem', 'parent_constitution_item_id', 'id');
    }

    public function children() {
         return $this->hasMany('App\FilingModel\ConstitutionItem', 'parent_constitution_item_id', 'id');
    }

    public function below() {
         return $this->belongsTo('App\FilingModel\ConstitutionItem', 'below_constitution_item_id', 'id');
    }

    public function template() {
         return $this->belongsTo('App\MasterModel\MasterConstitutionTemplate', 'constitution_template_id', 'id');
    }
}
