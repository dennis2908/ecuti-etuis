<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forma', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reference_no')->nullable();
            $table->unsignedInteger('eligibility_issue_id');
            $table->string('company_name')->nullable();
            $table->unsignedInteger('company_address_id')->nullable();
            $table->date('applied_at')->nullable();
            $table->date('received_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('eligibility_issue_id')
                ->references('id')
                ->on('eligibility_issue')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('company_address_id')
                ->references('id')
                ->on('address')
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
        Schema::dropIfExists('forma');
    }
}
