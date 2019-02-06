<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class Ectr4u extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ectr4u';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tenure_id',
        'name',
        'sector_id',
        'is_abroad',
        'programme_type_id',
        'objective',
        'location',
        'date_start',
        'date_end',
        'organizer',
        'organizer_name',
        'total_participant',
        'filing_status',
        'is_editable',
        'created_by_user_id',
    ];

    public function references() {
        return $this->morphMany('App\FilingModel\Reference', 'filing');
    }

    public function tenure() {
        return $this->belongsTo('App\FilingModel\Tenure', 'tenure_id', 'id');
    }

    public function programme_type() {
        return $this->belongsTo('App\MasterModel\MasterProgrammeType', 'programme_type_id', 'id');
    }

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'id');
    }

    public function sector() {
        return $this->belongsTo('App\MasterModel\MasterSector', 'sector_id', 'id');
    }

    public function status() {
        return $this->belongsTo('App\MasterModel\MasterFilingStatus', 'filing_status_id', 'id');
    }

    public function attachments() {
        return $this->morphMany('App\OtherModel\Attachment', 'filing');
    }

    public function federations() {
        return $this->hasMany('App\FilingModel\Ectr4uFederation', 'ectr4u_id', 'id');
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
