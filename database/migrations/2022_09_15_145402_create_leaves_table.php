<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->unsignedBigInteger('reason_id')->nullable();
            $table->date('leave_start_date');
            $table->date('leave_end_date');
            $table->smallInteger('amount');
            $table->string('status', 2);
            $table->tinyInteger('step_approval')->comment('step of approval');
            $table->tinyInteger('amount_approval')->comment('amount of approval');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
            $table->foreign('reason_id', 'FK_9D46AD5F59BB1592')->references('id')->on('absent_reasons');
            $table->foreign('employee_id', 'FK_9D46AD5F8C03F15C')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leaves');
    }
}
