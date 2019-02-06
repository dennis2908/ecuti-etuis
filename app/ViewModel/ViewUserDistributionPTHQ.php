<?php

namespace App\ViewModel;

use Illuminate\Database\Eloquent\Model;

class ViewUserDistributionPTHQ extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'view_user_distribution_pthq';

    public function user() {
        return $this->belongsTo('App\User', 'id', 'id');
    }
}
