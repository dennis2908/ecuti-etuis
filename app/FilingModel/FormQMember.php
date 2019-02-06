<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class FormQMember extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'formq_member';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'formq_id',
        'name',
    ];

    public function formq() {
        return $this->belongsTo('App\FilingModel\FormQ', 'formq_id', 'id');
    }

}
