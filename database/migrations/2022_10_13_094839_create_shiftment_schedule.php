<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftmentSchedule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shiftment_schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('shiftment_id');
            $table->string('work_day', 10);            
            $table->time('start_hour');
            $table->time('end_hour');
            $table->timestamps();
            $table->softDeletes();                                    
            $table->foreign('shiftment_id', 'shiftment_schedules_fk1')->references('id')->on('shiftments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shiftment_schedules');
    }
}
