<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalaryBenefitHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_benefit_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->unsignedBigInteger('component_id')->nullable();
            $table->unsignedBigInteger('contract_id')->nullable();
            $table->decimal('new_benefit_value', 15, 2,true)->nullable();
            $table->decimal('old_benefit_value', 15, 2,true)->nullable();            
            $table->string('description')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
            $table->foreign('contract_id', 'FK_2DF1CF532576E0FD')->references('id')->on('contracts');
            $table->foreign('employee_id', 'FK_2DF1CF538C03F15C')->references('id')->on('employees');
            $table->foreign('component_id', 'FK_2DF1CF53E2ABAFFF')->references('id')->on('salary_components');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salary_benefit_histories');
    }
}
