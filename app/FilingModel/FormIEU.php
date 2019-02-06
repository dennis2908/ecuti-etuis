<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class FormIEU extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'formieu';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tenure_id',
    	'filing_status_id',
        'applied_at',
        'is_editable',
        'created_by_user_id',
    ];

    public function references() {
        return $this->morphMany('App\FilingModel\Reference', 'filing');
    }

    public function tenure() {
        return $this->belongsTo('App\FilingModel\Tenure', 'tenure_id', 'id');
    }

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'id');
    }

    public function status() {
        return $this->belongsTo('App\MasterModel\MasterFilingStatus', 'filing_status_id', 'id');
    }

    public function formi() {
        return $this->hasOne('App\FilingModel\FormI', 'formieu_id', 'id');
    }

    public function forme() {
        return $this->hasOne('App\FilingModel\FormE', 'formieu_id', 'id');
    }

    public function formu() {
        return $this->morphOne('App\FilingModel\FormU', 'filing');
    }

    public function logs() {
        return $this->morphMany('App\LogModel\LogFiling', 'filing');
    }

    public function letters() {
        return $this->morphMany('App\OtherModel\Letter','filing');
    }

    public function distributions(){
        return $this->morphMany("App\FilingModel\Distribution","filing");
    }

    public function queries() {
        return $this->morphMany('App\FilingModel\Query', 'filing');
    }
}
