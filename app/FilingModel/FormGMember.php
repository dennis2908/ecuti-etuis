<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class FormGMember extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'formg_member';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'formg_id',
        'name',
    ];

    public function formg() {
        return $this->belongsTo('App\FilingModel\FormG', 'formg_id', 'id');
    }
}
