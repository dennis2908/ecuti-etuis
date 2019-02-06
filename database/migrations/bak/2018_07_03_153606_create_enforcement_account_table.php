<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnforcementAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enforcement_account', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('enforcement_id');
            $table->unsignedInteger('account_type_id')->nullable()->comment('1-Simpanan, 2-Semasa');
            $table->string('account_no')->nullable();
            $table->string('bank_name')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('enforcement_id')
                ->references('id')
                ->on('enforcement')
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
        Schema::dropIfExists('enforcement_account');
    }
}
