<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class FormLOfficer extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'forml_officer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'forml_id',
        'name',
        'designation_id',
        'held_at',
        'occupation',
        'nationality_country_id',
        'identification_no',
        'address_id',
        'date_of_birth',
        'created_by_user_id',
    ];

    public function forml() {
        return $this->belongsTo('App\FilingModel\FormL', 'forml_id', 'id');
    }

    public function designation() {
        return $this->belongsTo('App\MasterModel\MasterDesignation', 'designation_id', 'id');
    }

    public function nationality() {
        return $this->belongsTo('App\MasterModel\MasterCountry', 'nationality_country_id', 'id');
    }

    public function address() {
        return $this->belongsTo('App\OtherModel\Address', 'address_id', 'id');
    }

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'id');
    }

}
