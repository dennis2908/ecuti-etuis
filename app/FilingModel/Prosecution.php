<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class Prosecution extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'prosecution';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subpoena_approved_at',
        'io_notes',
        'po_notes',
        'applied_at',
        'filing_status_id',
        'is_editable',
        'created_by_user_id',
    ];

    public function references() {
        return $this->morphMany('App\FilingModel\Reference', 'filing');
    }

    public function pdw01() {
        return $this->hasOne('App\FilingModel\ProsecutionPDW01', 'prosecution_id', 'id');
    }

    public function pdw02() {
        return $this->hasOne('App\FilingModel\ProsecutionPDW02', 'prosecution_id', 'id');
    }

    public function pdw13() {
        return $this->hasOne('App\FilingModel\ProsecutionPDW13', 'prosecution_id', 'id');
    }

    public function pdw14() {
        return $this->hasOne('App\FilingModel\ProsecutionPDW14', 'prosecution_id', 'id');
    }

    public function status() {
        return $this->belongsTo('App\MasterModel\MasterFilingStatus', 'filing_status_id', 'id');
    }

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'id');
    }

    public function letters() {
        return $this->morphMany('App\OtherModel\Letter','filing');
    }

    public function distributions(){
        return $this->morphMany('App\FilingModel\Distribution','filing');
    }

    public function logs() {
        return $this->morphMany('App\LogModel\LogFiling', 'filing');
    }

    public function queries() {
        return $this->morphMany('App\FilingModel\Query', 'filing');
    }

}
