<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterSectorCategory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table = 'master_sector_category';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'name',
        'sector_id',
    ];

    public function sector() {
        return $this->belongsTo('App\MasterModel\MasterSector', 'sector_id', 'id');
    }
}
