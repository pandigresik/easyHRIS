<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStartEndPeriodPayroll extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payroll_periods', function(Blueprint $table){
            $table->date('start_period')->after('month');
            $table->date('end_period')->after('start_period');                        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payroll_periods', function(Blueprint $table){
            $table->dropColumn('start_period');
            $table->dropColumn('end_period');            
        });
    }
}
