<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table = 'member';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
         'filing_id',
         'filing_type',
         'name',
         'address_id',
     ];

     public function filing() {
         return $this->morphTo();
     }

     public function address() {
         return $this->belongsTo('App\OtherModel\Address', 'address_id', 'id');
     }

}
