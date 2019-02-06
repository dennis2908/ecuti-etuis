<?php

namespace App\OtherModel;

use Illuminate\Database\Eloquent\Model;

class ComplaintExternal extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'complaint_external';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'complaint',
    ];
}
