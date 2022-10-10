<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalaryGroupDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_group_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('component_id');
            $table->unsignedBigInteger('salary_group_id');
            $table->unsignedDecimal('component_value', 15)->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
            $table->unique(['component_id', 'salary_group_id'], 'uq_salary_group_detail_1');
            $table->foreign('salary_group_id', 'fk_salary_group_details_1')->references('id')->on('salary_groups')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('component_id', 'fk_salary_group_details_2')->references('id')->on('salary_components');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salary_group_details');
    }
}
