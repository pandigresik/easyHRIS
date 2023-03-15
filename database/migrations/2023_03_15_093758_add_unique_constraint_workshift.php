<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueConstraintWorkshift extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workshifts', function (Blueprint $table) {            
            $table->unique(['work_date', 'employee_id'], 'uq_workshift_1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('workshifts', function (Blueprint $table) {            
            $table->dropUnique('uq_workshift_1');
        });
    }
}
