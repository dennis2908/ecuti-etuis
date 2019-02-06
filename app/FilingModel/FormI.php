<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class FormI extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'formi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
         'formieu_id',
         'tenure_id',
         'address_id',
         'concluded_at',
         'meeting_type_id',
         'resolved_at',
         'applied_at',
         'secretary_user_id',
         'created_by_user_id',
     ];

     public function reference() {
         return $this->morphMany('App\FilingModel\Reference', 'filing');
     }

     public function formieu() {
         return $this->belongsTo('App\FilingModel\FormIEU', 'formieu_id', 'id');
     }

     public function tenure() {
         return $this->belongsTo('App\FilingModel\Tenure', 'tenure_id', 'id');
     }

     public function address() {
         return $this->belongsTo('App\OtherModel\Address', 'address_id', 'id');
     }

     public function secretary() {
         return $this->belongsTo('App\User', 'secretary_user_id', 'id');
     }

     public function created_by() {
         return $this->belongsTo('App\User', 'created_by_user_id', 'id');
     }

     public function distributions(){
         return $this->morphMany("App\FilingModel\Distribution","filing");
     }

     public function logs() {
         return $this->morphMany('App\LogModel\LogFiling', 'filing');
     }

     public function members() {
         return $this->morphMany('App\FilingModel\Member', 'filing');
     }
}
