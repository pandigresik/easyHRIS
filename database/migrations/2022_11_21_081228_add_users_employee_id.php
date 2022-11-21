<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsersEmployeeId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table){
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id', 'fk_users_employee_id_1')->on('employees')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table){            
            $table->dropForeign('fk_users_employee_id_1');
            $table->dropColumn('employee_id');
        });
    }
}
