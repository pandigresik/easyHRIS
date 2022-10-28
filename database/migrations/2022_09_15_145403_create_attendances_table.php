<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->unsignedBigInteger('shiftment_id')->nullable();
            $table->unsignedBigInteger('reason_id')->nullable();
            $table->date('attendance_date');
            $table->string('description')->nullable();
            $table->datetime('check_in_schedule')->nullable();
            $table->datetime('check_out_schedule')->nullable();
            $table->datetime('check_in')->nullable();
            $table->datetime('check_out')->nullable();
            $table->integer('early_in');
            $table->integer('early_out');
            $table->integer('late_in');
            $table->integer('late_out');
            $table->tinyInteger('absent');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
            $table->foreign('shiftment_id', 'FK_9C6B8FD4180FBE1')->references('id')->on('shiftments');
            $table->foreign('reason_id', 'FK_9C6B8FD459BB1592')->references('id')->on('absent_reasons');
            $table->foreign('employee_id', 'FK_9C6B8FD48C03F15C')->references('id')->on('employees');
            $table->unique(['employee_id', 'attendance_date'],'uq_attendances_1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
}
