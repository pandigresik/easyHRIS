<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_costs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('payroll_id');
            $table->unsignedBigInteger('component_id');
            $table->unsignedDecimal('benefit_value', 15)->nullable();            
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
            $table->foreign('payroll_id', 'FK_E8ECF5CDDBA340EA')->references('id')->on('payrolls');
            $table->foreign('component_id', 'FK_E8ECF5CDE2ABAFFF')->references('id')->on('salary_components');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_costs');
    }
}
