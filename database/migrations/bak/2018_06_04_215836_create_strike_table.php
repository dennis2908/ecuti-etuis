<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStrikeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('strike', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tenure_id');
            $table->unsignedInteger('address_id')->nullable();
            $table->string('employer')->nullable();
            $table->unsignedInteger('employer_address_id')->nullable();
            $table->text('address_strike')->nullable();
            $table->string('phone_president')->nullable();
            $table->string('phone_secretary')->nullable();
            $table->string('phone_treasurer')->nullable();
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

            $table->foreign('address_id', 'strike_address_id_foreign_key')
                ->references('id')
                ->on('address')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('employer_address_id')
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
        Schema::dropIfExists('strike');
    }
}
