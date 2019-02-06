<?php

namespace App\ViewModel;

use Illuminate\Database\Eloquent\Model;

class ViewUserDistributionPPW extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'view_user_distribution_ppw';

    public function user() {
        return $this->belongsTo('App\User', 'id', 'id');
    }
}
