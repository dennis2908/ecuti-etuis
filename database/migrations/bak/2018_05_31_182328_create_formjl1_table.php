<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormjl1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formjl1', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tenure_id');
            $table->string('firm_name')->nullable();
            $table->string('firm_registration_no')->nullable();
            $table->unsignedInteger('firm_address_id')->nullable();
            $table->string('auditor_name');
            $table->string('auditor_identification_no')->nullable();
            $table->date('applied_at')->nullable();
            $table->unsignedInteger('filing_status_id')->default(1);
            $table->boolean('is_editable')->default(1);
            $table->unsignedInteger('created_by_user_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('tenure_id')
                ->references('id')
                ->on('tenure')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('firm_address_id')
                ->references('id')
                ->on('address')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('filing_status_id')
                ->references('id')
                ->on('master_filing_status')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('created_by_user_id')
                ->references('id')
                ->on('user')
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
        Schema::dropIfExists('formjl1');
    }
}
