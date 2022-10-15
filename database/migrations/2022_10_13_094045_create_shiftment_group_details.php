<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftmentGroupDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shiftment_group_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('shiftment_group_id');
            $table->unsignedBigInteger('shiftment_id');
            $table->tinyInteger('sequence');
            $table->timestamps();
            $table->softDeletes();                        
            $table->foreign('shiftment_group_id', 'shiftment_group_details_fk1')->references('id')->on('shiftment_groups');
            $table->foreign('shiftment_id', 'shiftment_group_details_fk2')->references('id')->on('shiftments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shiftment_group_details');
    }
}
