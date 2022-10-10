<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('period_id')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->string('tax_group', 3)->nullable();
            $table->decimal('untaxable', 15, 2,true)->nullable()->comment('pendapatan tidak kena pajak');
            $table->decimal('taxable', 15, 2,true)->nullable();
            $table->decimal('tax_value', 15, 2,true)->nullable();            
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
            $table->foreign('employee_id', 'FK_A2E69AB88C03F15C')->references('id')->on('employees');
            $table->foreign('period_id', 'FK_A2E69AB8EC8B7ADE')->references('id')->on('payroll_periods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taxs');
    }
}
