<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class FormA extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'forma';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reference_no',
        'eligibility_issue_id',
        'company_name',
        'company_address_id',
        'applied_at',
        'received_at',
    ];

    public function eligibility_issue() {
        return $this->belongsTo('App\FilingModel\EligibilityIssue', 'eligibility_issue_id', 'id');
    }

    public function company_address() {
        return $this->belongsTo('App\OtherModel\Address', 'company_address_id', 'id');
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
