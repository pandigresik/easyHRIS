<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueKeyWorksfhitGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workshift_groups', function (Blueprint $table) {
            $table->unique(['shiftment_group_id', 'work_date'], 'uq_workshift_groups_1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('workshift_groups', function (Blueprint $table) {
            $table->dropIndex('uq_workshift_groups_1');
        });
    }
}
