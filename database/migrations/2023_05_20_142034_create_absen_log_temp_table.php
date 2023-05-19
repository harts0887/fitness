<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbsenLogTempTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absen_log_temp', function (Blueprint $table) {
            $table->bigincrements('id'); 
            $table->string('text_1')->nullable();
            $table->string('text_2')->nullable();
            $table->string('text_3')->nullable();
            $table->string('text_4')->nullable();
            $table->string('text_5')->nullable();
            $table->string('text_6')->nullable();
            $table->string('text_7')->nullable();
            $table->string('text_8')->nullable();
            $table->string('text_9')->nullable();
            $table->string('temp_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absen_log_temp');
    }
}
