<?php

namespace App\OtherModel;

use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'letter';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'letter_type_id',
        'data',
        'module_id',
        'filing_id',
        'filing_type',
        'entity_id',
        'entity_type',
        'created_by_user_id',
    ];

    public function type() {
        return $this->belongsTo('App\MasterModel\MasterLetterType', 'letter_type_id', 'id');
    }

    public function filing() {
        return $this->morphTo();
    }

    public function entity() {
        return $this->morphTo();
    }

    public function module() {
        return $this->belongsTo('App\MasterModel\MasterModule', 'module_id', 'id');
    }

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'id');
    }

    public function attachment() {
        return $this->morphOne('App\OtherModel\Attachment', 'filing');
    }

    public function reference() {
        return $this->morphOne('App\FilingModel\Reference', 'filing');
    }

    public function attachments() {
        return $this->morphMany('App\OtherModel\Attachment', 'filing');
    }

}
