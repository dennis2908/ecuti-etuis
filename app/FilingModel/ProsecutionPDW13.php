<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class ProsecutionPDW13 extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'prosecution_pdw13';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'prosecution_id',
        'facts',
        'applied_at',
        'created_by_user_id',
    ];

    public function references() {
        return $this->morphMany('App\FilingModel\Reference', 'filing');
    }

    public function prosecution() {
        return $this->belongsTo('App\FilingModel\Prosecution', 'prosecution_id', 'id');
    }

    public function accused() {
        return $this->hasMany('App\FilingModel\ProsecutionPDW13Accused', 'prosecution_pdw13_id', 'id');
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
