<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class FormF extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'formf';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'entity_id',
        'entity_type',
        'address_id',
        'filing_status_id',
        'is_editable',
        'applied_at',
        'created_by_user_id',
        'created_at',
        'updated_at',
    ];

    public function entity() {
        return $this->morphTo();
    }

    public function references() {
        return $this->morphMany('App\FilingModel\Reference', 'filing');
    }

    public function address() {
        return $this->belongsTo('App\OtherModel\Address', 'address_id', 'id');
    }

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'id');
    }

    public function status() {
        return $this->belongsTo('App\MasterModel\MasterFilingStatus', 'filing_status_id', 'id');
    }

    public function attachments() {
        return $this->morphMany('App\OtherModel\Attachment', 'filing');
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
