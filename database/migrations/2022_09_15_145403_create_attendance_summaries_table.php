<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendanceSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_summaries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->smallInteger('year');
            $table->smallInteger('month');
            $table->integer('total_workday');
            $table->integer('total_in');
            $table->integer('total_loyality');
            $table->integer('total_absent');
            $table->decimal('total_overtime', 5,2);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
            $table->index(['month', 'year'], 'attendance_summaries_idx');
            $table->foreign('employee_id', 'FK_13FC96F08C03F15C')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance_summaries');
    }
}
