<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class FundCollection extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table = 'fund_collection';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fund_id',
        'prior_fund_id',
        'year',
        'objective',
    ];

    public function fund() {
        return $this->belongsTo('App\FilingModel\Fund', 'fund_id', 'id');
    }

    public function prior_fund() {
        return $this->belongsTo('App\FilingModel\Fund', 'prior_fund_id', 'id');
    }
}
