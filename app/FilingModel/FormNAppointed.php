<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class FormNAppointed extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'formn_appointed';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'formn_id',
        'name',
        'designation_id',
        'date_of_birth',
        'occupation',
        'appointed_at',
        'created_by_user_id',
        'address_id',
    ];

    public function formn() {
        return $this->belongsTo('App\FilingModel\FormN', 'formn_id', 'id');
    }

    public function address() {
        return $this->belongsTo('App\OtherModel\Address', 'address_id', 'id');
    }

    public function designation() {
        return $this->belongsTo('App\MasterModel\MasterDesignation', 'designation_id', 'id');
    }

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'id');
    }
}
