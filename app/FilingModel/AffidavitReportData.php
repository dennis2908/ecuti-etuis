<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class AffidavitReportData extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'affidavit_report_data';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'affidavit_id',
        'data',
        'created_by_user_id',
    ];

    public function affidavit() {
        return $this->belongsTo('App\FilingModel\Affidavit', 'affidavit_id', 'id');
    }

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'id');
    }
}
