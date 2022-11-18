<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupingPayrollEmployeeReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grouping_payroll_employee_report', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('grouping_payroll_entity_id');
            $table->foreign('employee_id', 'fk_grouping_payroll_employee_1')->on('employees')->references('id');
            $table->foreign('grouping_payroll_entity_id', 'fk_grouping_payroll_employee_2')->on('grouping_payroll_entities')->references('id');
            $table->unique(['employee_id', 'grouping_payroll_entity_id'], 'uq_grouping_payroll_employee_1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grouping_payroll_employee_report');
    }
}
