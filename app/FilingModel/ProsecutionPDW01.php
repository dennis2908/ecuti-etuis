<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class ProsecutionPDW01 extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'prosecution_pdw01';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'prosecution_id',
        'subject',
        'province_office_id',
        'report_reference_no',
        'report_date',
        'fault',
        'applied_at',
        'is_editable',
        'created_by_user_id',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['pw'];

    public function references() {
        return $this->morphMany('App\FilingModel\Reference', 'filing');
    }

    public function attachments() {
        return $this->morphMany('App\OtherModel\Attachment', 'filing');
    }

    public function prosecution() {
        return $this->belongsTo('App\FilingModel\Prosecution', 'prosecution_id', 'id');
    }

    public function province_office() {
        return $this->belongsTo('App\MasterModel\MasterProvinceOffice', 'province_office_id', 'id');
    }

    public function getPwAttribute() {
        return $this->province_office->pw;
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
