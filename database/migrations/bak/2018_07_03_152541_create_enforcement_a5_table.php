<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnforcementA5Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enforcement_a5', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('enforcement_id');
            $table->unsignedInteger('branch_id')->nullable();
            $table->date('membership_at')->nullable();
            $table->unsignedInteger('total_registered_male')->nullable();
            $table->unsignedInteger('total_registered_female')->nullable();
            $table->unsignedInteger('total_rightful_male')->nullable();
            $table->unsignedInteger('total_rightful_female')->nullable();
            $table->unsignedInteger('total_chairman_male')->nullable();
            $table->unsignedInteger('total_chairman_female')->nullable();
            $table->unsignedInteger('total_vice_chairman_male')->nullable();
            $table->unsignedInteger('total_vice_chairman_female')->nullable();
            $table->unsignedInteger('total_secretary_male')->nullable();
            $table->unsignedInteger('total_secretary_female')->nullable();
            $table->unsignedInteger('total_asst_secretary_male')->nullable();
            $table->unsignedInteger('total_asst_secretary_female')->nullable();
            $table->unsignedInteger('total_treasurer_male')->nullable();
            $table->unsignedInteger('total_treasurer_female')->nullable();
            $table->unsignedInteger('total_committee_male')->nullable();
            $table->unsignedInteger('total_committee_female')->nullable();
            $table->unsignedInteger('total_race_malay_male')->nullable();
            $table->unsignedInteger('total_race_malay_female')->nullable();
            $table->unsignedInteger('total_race_chinese_male')->nullable();
            $table->unsignedInteger('total_race_chinese_female')->nullable();
            $table->unsignedInteger('total_race_indian_male')->nullable();
            $table->unsignedInteger('total_race_indian_female')->nullable();
            $table->unsignedInteger('total_race_bumiputera_male')->nullable();
            $table->unsignedInteger('total_race_bumiputera_female')->nullable();
            $table->unsignedInteger('total_race_others_male')->nullable();
            $table->unsignedInteger('total_race_others_female')->nullable();
            $table->unsignedInteger('total_allied_malay_male')->nullable();
            $table->unsignedInteger('total_allied_malay_female')->nullable();
            $table->unsignedInteger('total_allied_chinese_male')->nullable();
            $table->unsignedInteger('total_allied_chinese_female')->nullable();
            $table->unsignedInteger('total_allied_indian_male')->nullable();
            $table->unsignedInteger('total_allied_indian_female')->nullable();
            $table->unsignedInteger('total_allied_bumiputera_male')->nullable();
            $table->unsignedInteger('total_allied_bumiputera_female')->nullable();
            $table->unsignedInteger('total_allied_others_male')->nullable();
            $table->unsignedInteger('total_allied_others_female')->nullable();
            $table->unsignedInteger('total_indonesian_male')->nullable();
            $table->unsignedInteger('total_indonesian_female')->nullable();
            $table->unsignedInteger('total_vietnamese_male')->nullable();
            $table->unsignedInteger('total_vietnamese_female')->nullable();
            $table->unsignedInteger('total_philippines_male')->nullable();
            $table->unsignedInteger('total_philippines_female')->nullable();
            $table->unsignedInteger('total_myanmar_male')->nullable();
            $table->unsignedInteger('total_myanmar_female')->nullable();
            $table->unsignedInteger('total_cambodia_male')->nullable();
            $table->unsignedInteger('total_cambodia_female')->nullable();
            $table->unsignedInteger('total_bangladesh_male')->nullable();
            $table->unsignedInteger('total_bangladesh_female')->nullable();
            $table->unsignedInteger('total_india_male')->nullable();
            $table->unsignedInteger('total_india_female')->nullable();
            $table->unsignedInteger('total_nepal_male')->nullable();
            $table->unsignedInteger('total_nepal_female')->nullable();
            $table->unsignedInteger('total_others_male')->nullable();
            $table->unsignedInteger('total_others_female')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('enforcement_id')
                ->references('id')
                ->on('enforcement')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('branch_id')
                ->references('id')
                ->on('branch')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enforcement_a5');
    }
}
