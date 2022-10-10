<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobPlacementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_placements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('joblevel_id')->nullable();
            $table->unsignedBigInteger('jobtitle_id')->nullable();
            $table->unsignedBigInteger('supervisor_id')->nullable();
            $table->unsignedBigInteger('contract_id')->nullable();
            $table->tinyInteger('active');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
            $table->foreign('supervisor_id', 'FK_9689A96419E9AC5F')->references('id')->on('employees');
            $table->foreign('contract_id', 'FK_9689A9642576E0FD')->references('id')->on('contracts');
            $table->foreign('employee_id', 'FK_9689A9648C03F15C')->references('id')->on('employees');
            $table->foreign('company_id', 'FK_9689A964979B1AD6')->references('id')->on('companies');
            $table->foreign('department_id', 'FK_9689A964AE80F5DF')->references('id')->on('departments');
            $table->foreign('joblevel_id', 'FK_9689A964B1161D41')->references('id')->on('job_levels');
            $table->foreign('jobtitle_id', 'FK_9689A964E438D15B')->references('id')->on('job_titles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_placements');
    }
}
