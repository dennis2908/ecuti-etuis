<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class FundBranch extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table = 'fund_branch';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fund_id',
        'branch_id',
    ];

    public function fund() {
        return $this->belongsTo('App\FilingModel\Fund', 'fund_id', 'id');
    }

    public function branch() {
        return $this->belongsTo('App\FilingModel\Branch', 'branch_id', 'id');
    }
}
