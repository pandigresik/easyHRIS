<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkshiftGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workshift_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('shiftment_group_id');
            $table->unsignedBigInteger('shiftment_id');
            $table->date('work_date');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
            $table->foreign('shiftment_group_id', 'workshift_groups_fk1')->references('id')->on('shiftment_groups');
            $table->foreign('shiftment_id', 'workshift_groups_fk2')->references('id')->on('shiftments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workshift_groups');
    }
}
