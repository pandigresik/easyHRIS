<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRitaseDriver extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ritase_drivers', function (Blueprint $table) {
            $table->bigIncrements('id');            
            $table->unsignedBigInteger('employee_id');
            $table->date('work_date');
            $table->unsignedSmallInteger('km');
            $table->unsignedTinyInteger('double_rit');            
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
            $table->foreign('employee_id','fk_ritase_driver_1')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ritase_drivers');
    }
}
