<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOvertimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overtimes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('shiftment_id');
            $table->unsignedBigInteger('approved_by_id')->nullable();
            $table->date('overtime_date');
            $table->time('start_hour');
            $table->time('end_hour');
            $table->time('start_hour_real')->nullable();
            $table->time('end_hour_real')->nullable();
            $table->unsignedFloat('raw_value');
            $table->unsignedFloat('calculated_value')->nullable();
            $table->tinyInteger('holiday');
            $table->tinyInteger('overday');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
            $table->foreign('shiftment_id', 'FK_4B7D14D5180FBE1')->references('id')->on('shiftments');
            $table->foreign('approved_by_id', 'FK_4B7D14D52D234F6A')->references('id')->on('employees');
            $table->foreign('employee_id', 'FK_4B7D14D58C03F15C')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('overtimes');
    }
}
