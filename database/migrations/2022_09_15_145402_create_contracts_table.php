<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->bigIncrements('id');            
            $table->string('letter_number', 27)->nullable();
            $table->string('subject');
            $table->string('description')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->date('signed_date');
            $table->string('path_file')->nullable();
            $table->longText('tags')->nullable();
            $table->tinyInteger('used')->nullable()->default(0);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts');
    }
}
