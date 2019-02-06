<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class ConstitutionChange extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'constitution_change';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'constitution_id',
        'constitution_item_id',
        'change_type_id',
        'justification',
        'is_approved',
        'result_details',
        'created_by_user_id',
    ];

    public function constitution() {
         return $this->belongsTo('App\FilingModel\Constitution', 'constitution_id', 'id');
    }

    public function item() {
         return $this->belongsTo('App\FilingModel\ConstitutionItem', 'constitution_item_id', 'id');
    }

    public function type() {
         return $this->belongsTo('App\MasterModel\MasterChangeType', 'change_type_id', 'id');
    }

    public function created_by() {
         return $this->belongsTo('App\User', 'created_by_user_id', 'id');
    }
}
