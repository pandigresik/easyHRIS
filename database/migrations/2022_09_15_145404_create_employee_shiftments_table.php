<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeShiftmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_shiftments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('shiftment_group_id');
            $table->char('active', 1)->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
            $table->unique(['employee_id', 'shiftment_group_id'], 'employee_shiftments_idx');
            $table->foreign('employee_id', 'employee_shiftments_fk1')->references('id')->on('employees');
            $table->foreign('shiftment_group_id', 'employee_shiftments_fk2')->references('id')->on('shiftment_groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_shiftments');
    }
}
