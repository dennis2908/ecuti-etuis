<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class FundParticipant extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table = 'fund_participant';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fund_id',
        'party_type_id',
        'member_no',
        'name',
        'occupation',
        'registration_no',
        'address_company',
        'identification_no',
        'phone',
        'fax',
        'email',
    ];

    public function fund() {
        return $this->belongsTo('App\FilingModel\Fund', 'fund_id', 'id');
    }

    public function party_type() {
        return $this->belongsTo('App\MasterModel\MasterPartyType', 'party_type_id', 'id');
    }
}
