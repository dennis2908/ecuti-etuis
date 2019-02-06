<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAffidavitReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affidavit_report', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('affidavit_id');
            $table->unsignedInteger('attorney_id')->nullable();
            $table->unsignedInteger('court_id')->nullable();
            $table->boolean('is_sir')->nullable();
            $table->string('up')->nullable();
            $table->string('judicial_no')->nullable();
            $table->unsignedInteger('filing_status_id')->default(1);
            $table->boolean('is_editable')->default(1);
            $table->unsignedInteger('created_by_user_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('affidavit_id')
                ->references('id')
                ->on('affidavit')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('attorney_id')
                ->references('id')
                ->on('master_attorney')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('court_id')
                ->references('id')
                ->on('master_court')
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
        Schema::dropIfExists('affidavit_report');
    }
}
