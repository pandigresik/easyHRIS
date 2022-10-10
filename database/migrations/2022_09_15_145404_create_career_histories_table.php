<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCareerHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('career_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('joblevel_id');
            $table->unsignedBigInteger('jobtitle_id');
            $table->unsignedBigInteger('supervisor_id')->nullable();
            $table->unsignedBigInteger('contract_id')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
            $table->foreign('supervisor_id', 'FK_6872056C19E9AC5F')->references('id')->on('employees');
            $table->foreign('contract_id', 'FK_6872056C2576E0FD')->references('id')->on('contracts');
            $table->foreign('employee_id', 'FK_6872056C8C03F15C')->references('id')->on('employees');
            $table->foreign('company_id', 'FK_6872056C979B1AD6')->references('id')->on('companies');
            $table->foreign('department_id', 'FK_6872056CAE80F5DF')->references('id')->on('departments');
            $table->foreign('joblevel_id', 'FK_6872056CB1161D41')->references('id')->on('job_levels');
            $table->foreign('jobtitle_id', 'FK_6872056CE438D15B')->references('id')->on('job_titles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('career_histories');
    }
}
