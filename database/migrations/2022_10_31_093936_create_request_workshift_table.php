<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestWorkshiftTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('request_workshifts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('shiftment_id');
            $table->unsignedBigInteger('shiftment_id_origin');
            $table->date('work_date');
            $table->datetime('start_hour')->nullable();
            $table->datetime('end_hour')->nullable();
            $table->string('status', 2)->nullable()->default('N');            
            $table->string('description')->nullable();            
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
            $table->foreign('shiftment_id', 'FK_request_workshift_1')->references('id')->on('shiftments');
            $table->foreign('employee_id', 'FK_request_workshift_2')->references('id')->on('employees');
            $table->foreign('shiftment_id_origin', 'FK_request_workshift_3')->references('id')->on('shiftments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_workshifts');
    }
}
