<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobMutationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_mutations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->unsignedBigInteger('old_company_id')->nullable();
            $table->unsignedBigInteger('old_department_id')->nullable();
            $table->unsignedBigInteger('old_joblevel_id')->nullable();
            $table->unsignedBigInteger('old_jobtitle_id')->nullable();
            $table->unsignedBigInteger('old_supervisor_id')->nullable();
            $table->unsignedBigInteger('new_company_id')->nullable();
            $table->unsignedBigInteger('new_department_id')->nullable();
            $table->unsignedBigInteger('new_joblevel_id')->nullable();
            $table->unsignedBigInteger('new_jobtitle_id')->nullable();
            $table->unsignedBigInteger('new_supervisor_id')->nullable();
            $table->unsignedBigInteger('contract_id')->nullable();
            $table->string('type', 1)->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
            $table->foreign('new_joblevel_id', 'FK_882F3E4B2319AC39')->references('id')->on('job_levels');
            $table->foreign('contract_id', 'FK_882F3E4B2576E0FD')->references('id')->on('contracts');
            $table->foreign('old_company_id', 'FK_882F3E4B2BB82D88')->references('id')->on('companies');
            $table->foreign('old_joblevel_id', 'FK_882F3E4B3D794285')->references('id')->on('job_levels');
            $table->foreign('new_supervisor_id', 'FK_882F3E4B42694EB4')->references('id')->on('employees');
            $table->foreign('new_company_id', 'FK_882F3E4B4AA4F91A')->references('id')->on('companies');
            $table->foreign('old_supervisor_id', 'FK_882F3E4B4DAB7E1F')->references('id')->on('employees');
            $table->foreign('old_jobtitle_id', 'FK_882F3E4B68578E9F')->references('id')->on('job_titles');
            $table->foreign('new_jobtitle_id', 'FK_882F3E4B76376023')->references('id')->on('job_titles');
            $table->foreign('employee_id', 'FK_882F3E4B8C03F15C')->references('id')->on('employees');
            $table->foreign('new_department_id', 'FK_882F3E4BF5001734')->references('id')->on('departments');
            $table->foreign('old_department_id', 'FK_882F3E4BFAC2279F')->references('id')->on('departments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_mutations');
    }
}
