<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class Constitution extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'constitution';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'entity_id',
        'entity_type',
        'filing_status_id',
        'is_editable',
        'created_by_user_id',
    ];

    public function entity() {
        return $this->morphTo();
    }

    public function items() {
         return $this->hasMany('App\FilingModel\ConstitutionItem', 'constitution_id', 'id');
    }

    public function changes() {
         return $this->hasMany('App\FilingModel\ConstitutionChange', 'constitution_id', 'id');
    }

    public function created_by() {
         return $this->belongsTo('App\User', 'created_by_user_id', 'id');
    }

    public function reference() {
        return $this->morphOne('App\FilingModel\Reference', 'filing');
    }

    public function status() {
        return $this->belongsTo('App\MasterModel\MasterFilingStatus', 'filing_status_id', 'id');
    }

    public function distributions(){
        return $this->morphMany('App\FilingModel\Distribution', 'filing');
    }

    public function logs() {
        return $this->morphMany('App\LogModel\LogFiling', 'filing');
    }

    public function queries() {
        return $this->morphMany('App\FilingModel\Query', 'filing');
    }

    public function references() {
        return $this->morphMany('App\FilingModel\Reference', 'filing');
    }
}
