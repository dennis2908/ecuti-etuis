<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterReport extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table = 'master_report';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
    	'name',
        'report_type_id',
    ];

    public function type() {
        return $this->belongsTo('App\MasterModel\MasterReportType', 'report_type_id', 'id');
    }
}
