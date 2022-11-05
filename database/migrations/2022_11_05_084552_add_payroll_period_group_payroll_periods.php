<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPayrollPeriodGroupPayrollPeriods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payroll_periods', function(Blueprint $table){
            $table->unsignedBigInteger('payroll_period_group_id')->nullable();
            $table->foreign('payroll_period_group_id', 'fk_payroll_period_3')->references('id')->on('payroll_period_groups');            
            $table->unique(['company_id','year','month','start_period','end_period','payroll_period_group_id'],'uq_payroll_periods_1');
        });
        Schema::table('employees', function(Blueprint $table){
            $table->unsignedBigInteger('payroll_period_group_id')->nullable();
            $table->foreign('payroll_period_group_id', 'fk_employees_payroll_5')->references('id')->on('payroll_period_groups');            
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
            $table->dropForeign('fk_payroll_period_3');
            $table->dropUnique('uq_payroll_periods_1');
            $table->dropColumn('payroll_period_group_id');                                    
        });
        Schema::table('employees', function(Blueprint $table){
            $table->dropForeign('fk_employees_payroll_5');
            $table->dropColumn('payroll_period_group_id'); 
        });
    }
}
