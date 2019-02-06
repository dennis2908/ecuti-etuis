<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class AffidavitReport extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'affidavit_report';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'affidavit_id',
        'attorney_id',
        'court_id',
        'is_sir',
        'u.p',
        'judicial_no',
        'filing_status_id',
        'is_editable',
        'created_by_user_id',
    ];

    public function affidavit() {
        return $this->belongsTo('App\FilingModel\Affidavit', 'affidavit_id', 'id');
    }

    public function attorney() {
        return $this->belongsTo('App\MasterModel\MasterAttorney', 'attorney_id', 'id');
    }

    public function court() {
        return $this->belongsTo('App\MasterModel\MasterCourt', 'court_id', 'id');
    }

    public function status() {
        return $this->belongsTo('App\MasterModel\MasterFilingStatus', 'filing_status_id', 'id');
    }

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'id');
    }

    public function attachments() {
        return $this->morphMany('App\OtherModel\Attachment', 'filing');
    }
}
