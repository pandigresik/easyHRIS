<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStartHourWorksfhitGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workshift_groups', function (Blueprint $table) {
            $table->datetime('start_hour')->nullable();
            $table->datetime('end_hour')->nullable();
        });

        Schema::table('workshifts', function (Blueprint $table) {
            $table->datetime('start_hour')->nullable();
            $table->datetime('end_hour')->nullable();
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
            $table->dropColumn('start_hour');
            $table->dropColumn('end_hour');
        });

        Schema::table('workshifts', function (Blueprint $table) {
            $table->dropColumn('start_hour');
            $table->dropColumn('end_hour');
        });
    }
}
