<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('contract_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('joblevel_id')->nullable();
            $table->unsignedBigInteger('jobtitle_id')->nullable();
            $table->unsignedBigInteger('supervisor_id')->nullable();
            $table->unsignedBigInteger('region_of_birth_id')->nullable();
            $table->unsignedBigInteger('city_of_birth_id')->nullable();
            $table->string('address')->nullable();
            $table->date('join_date');
            $table->string('employee_status', 1);
            $table->string('code', 17);
            $table->string('full_name');
            $table->string('gender', 1);
            $table->date('date_of_birth');
            $table->string('identity_number', 27)->nullable();
            $table->string('identity_type', 5)->nullable();
            $table->string('marital_status', 1)->nullable();
            $table->string('email')->nullable();
            $table->integer('leave_balance')->nullable();
            $table->string('tax_group', 3)->nullable();
            $table->date('resign_date')->nullable();
            $table->tinyInteger('have_overtime_benefit');
            $table->string('risk_ratio', 3)->nullable();
            $table->string('profile_image')->nullable();
            $table->integer('profile_size')->nullable();            
            $table->unsignedBigInteger('salary_group_id')->nullable();
            $table->unsignedBigInteger('shiftment_group_id')->nullable();            
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
            $table->index(['code', 'full_name'], 'employees_idx');
            $table->foreign('supervisor_id', 'FK_BA82C30019E9AC5F')->references('id')->on('employees');
            $table->foreign('contract_id', 'FK_BA82C3002576E0FD')->references('id')->on('contracts');
            $table->foreign('city_of_birth_id', 'FK_BA82C3005BC7B076')->references('id')->on('cities');
            $table->foreign('company_id', 'FK_BA82C300979B1AD6')->references('id')->on('companies');
            $table->foreign('department_id', 'FK_BA82C300AE80F5DF')->references('id')->on('departments');
            $table->foreign('region_of_birth_id', 'FK_BA82C300AF5F9BA3')->references('id')->on('regions');
            $table->foreign('joblevel_id', 'FK_BA82C300B1161D41')->references('id')->on('job_levels');
            $table->foreign('jobtitle_id', 'FK_BA82C300E438D15B')->references('id')->on('job_titles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
