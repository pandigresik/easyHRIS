<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('payroll_id');
            $table->unsignedBigInteger('component_id');
            $table->unsignedDecimal('benefit_value', 15)->nullable();
            $table->tinyInteger('sign_value')->nullable();     
            $table->string('description', 255)->nullable();             
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
            $table->foreign('payroll_id', 'FK_E4A11F3DDBA340EA')->references('id')->on('payrolls');
            $table->foreign('component_id', 'FK_E4A11F3DE2ABAFFF')->references('id')->on('salary_components');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payroll_details');
    }
}
