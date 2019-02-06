<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class FundBank extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table = 'fund_bank';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fund_id',
        'name',
        'account_no',
        'balance',
    ];

    public function fund() {
        return $this->belongsTo('App\FilingModel\Fund', 'fund_id', 'id');
    }
}
