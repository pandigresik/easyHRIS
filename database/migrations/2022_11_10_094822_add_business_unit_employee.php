<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBusinessUnitEmployee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function(Blueprint $table){
            $table->unsignedBigInteger('business_unit_id')->after('department_id')->nullable();
            $table->foreign('business_unit_id','fk_employees_bu_1')->on('business_units')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function(Blueprint $table){
            $table->dropColumn('business_unit_id');
            $table->dropForeign('fk_employees_bu_1');
        });
    }
}
