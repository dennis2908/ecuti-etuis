<?php

namespace App\FilingModel;

use Illuminate\Database\Eloquent\Model;

class EnforcementA5 extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'enforcement_a5';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'enforcement_id',
        'branch_id',
        'membership_at',
        'total_rightful_male',
        'total_rightful_female',
        'total_registered_male',
        'total_registered_female',
        'total_chairman_male',
        'total_chairman_female',
        'total_vice_chairman_male',
        'total_vice_chairman_female',
        'total_secretary_male',
        'total_secretary_female',
        'total_vice_secretary_male',
        'total_vice_secretary_female',
        'total_treasurer_male',
        'total_treasurer_female',
        'total_committee_male',
        'total_committee_female',
        'total_race_malay_male',
        'total_race_malay_female',
        'total_race_chinese_male',
        'total_race_chinese_female',
        'total_race_indian_male',
        'total_race_indian_female',
        'total_race_bumiputera_male',
        'total_race_bumiputera_female',
        'total_race_others_male',
        'total_race_other_females',
        'total_allied_malay_male',
        'total_allied_malay_female',
        'total_allied_chinese_male',
        'total_allied_chinese_female',
        'total_allied_indian_male',
        'total_allied_indian_female',
        'total_allied_bumiputera_male',
        'total_allied_bumiputera_female',
        'total_allied_others_male',
        'total_allied_others_female',
        'total_indonesian_male',
        'total_indonesian_female',
        'total_viatnamese_male',
        'total_viatnamese_female',
        'total_mynmar_male',
        'total_mynmar_female',
        'total_philiphine_male',
        'total_philiphine_female',
        'total_kemboja_male',
        'total_kemboja_female',
        'total_bangladesh_male',
        'total_bangladesh_female',
        'total_india_male',
        'total_india_female',
        'total_nepal_male',
        'total_nepal_female',
        'total_others_male',
        'total_others_female',

    ];

    public function enforcement() {
        return $this->belongsTo('App\FilingModel\Enforcement', 'enforcement_id', 'id');
    }

    public function branch() {
        return $this->belongsTo('App\FilingModel\Branch', 'branch_id', 'id');
    }

}
