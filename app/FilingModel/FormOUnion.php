<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class FormOUnion extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'formo_union';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'formo_id',
        'user_union_id',
    ];

    public function formo() {
        return $this->belongsTo('App\FilingModel\FormO', 'formo_id', 'id');
    }

    public function union() {
        return $this->belongsTo('App\UserUnion', 'user_union_id', 'id');
    }

}
