<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machines', function (Blueprint $table) {
			$table->increments('id');
			$table->string('initial_store')->nullable();
			$table->integer('machine_number')->nullable();
			$table->string('machine_type')->nullable();
			$table->string('ip_address')->nullable();
			$table->timestamps();
			$table->string('status')->nullable();
			$table->timestamp('time_log')->nullable();
			$table->integer('data_log')->nullable();
			$table->integer('group_server')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('machines');
    }
}
