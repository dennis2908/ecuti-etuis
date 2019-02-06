<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormjTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formj', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tenure_id');
            $table->unsignedInteger('address_id')->nullable();
            $table->unsignedInteger('new_address_id')->nullable();
            $table->unsignedInteger('province_office_id')->nullable();
            $table->unsignedInteger('meeting_type_id')->nullable();
            $table->date('resolved_at')->nullable();
            $table->unsignedInteger('justification_id')->nullable();
            $table->text('justification_description')->nullable();
            $table->date('moved_at')->nullable();
            $table->unsignedInteger('address_type_id')->nullable();
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

            $table->foreign('address_id')
                ->references('id')
                ->on('address')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('new_address_id')
                ->references('id')
                ->on('address')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('province_office_id')
                ->references('id')
                ->on('master_province_office')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('meeting_type_id')
                ->references('id')
                ->on('master_meeting_type')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('justification_id')
                ->references('id')
                ->on('master_justification')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('address_type_id')
                ->references('id')
                ->on('master_address_type')
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
        Schema::dropIfExists('formj');
    }
}
