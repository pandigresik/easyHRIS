<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueConstraintSalaryBenefit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salary_benefits', function (Blueprint $table) {
            $table->unique(['employee_id','component_id'], 'uq_salary_benefits_1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salary_benefits', function (Blueprint $table) {
            $table->dropIndex('uq_salary_benefits_1');
        });
    }
}
