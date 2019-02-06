<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class FormLLeaving extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table = 'forml_leaving';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'forml_id',
        'officer_id',
        'left_at',
        'created_by_user_id'
    ];

    public function forml() {
        return $this->belongsTo('App\FilingModel\FormL', 'forml_id', 'id');
    }

    public function officer() {
        return $this->belongsTo('App\FilingModel\Officer', 'officer_id', 'id');
    }

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'id');
    }

}
