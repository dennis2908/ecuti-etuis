<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class Affidavit extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'affidavit';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'applicant',
        'court_registration_no',
        'applied_at',
        'filing_status_id',
        'is_editable',
        'created_by_user_id',
    ];

    public function references() {
        return $this->morphMany('App\FilingModel\Reference', 'filing');
    }

    public function report() {
        return $this->hasOne('App\FilingModel\AffidavitReport', 'affidavit_id', 'id');
    }

    public function report_data() {
        return $this->hasMany('App\FilingModel\AffidavitReportData', 'affidavit_id', 'id');
    }

    public function status() {
        return $this->belongsTo('App\MasterModel\MasterFilingStatus', 'filing_status_id', 'id');
    }

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'id');
    }

    public function respondents() {
        return $this->hasMany('App\FilingModel\AffidavitRespondent', 'affidavit_id', 'id');
    }

    public function attachments() {
        return $this->morphMany('App\OtherModel\Attachment', 'filing');
    }

    public function letters() {
        return $this->morphMany('App\OtherModel\Letter','filing');
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
}
