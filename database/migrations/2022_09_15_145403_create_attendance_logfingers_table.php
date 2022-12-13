<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendanceLogfingersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_logfingers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id');
            $table->char('type_absen', 1)->nullable();
            $table->dateTime('fingertime');
            $table->unsignedBigInteger('fingerprint_device_id')->nullable();
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->dateTime('updated_at')->nullable()->useCurrent();
            $table->dateTime('deleted_at')->nullable();
            $table->foreign('employee_id', 'fk_attendance_log_1')->references('id')->on('employees');
            $table->foreign('fingerprint_device_id', 'fk_attendance_log_2')->references('id')->on('fingerprint_devices');
            $table->unique(['employee_id', 'fingertime'], 'uq_attendance_logfingers_1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance_logfingers');
    }
}
