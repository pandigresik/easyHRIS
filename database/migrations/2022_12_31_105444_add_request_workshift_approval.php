<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRequestWorkshiftApproval extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_workshifts', function(Blueprint $table){
            $table->tinyInteger('step_approval')->after('status')->nullable()->default(1)->comment('step of approval');
            $table->tinyInteger('amount_approval')->after('step_approval')->nullable()->default(0)->comment('amount of approval');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('request_workshifts', function(Blueprint $table){
            $table->dropColumn('step_approval');
            $table->dropColumn('amount_approval');
        });
    }
}
