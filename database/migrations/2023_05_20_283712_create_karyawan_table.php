<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateKaryawanTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('karyawan', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('full_name')->nullable();
			$table->string('initial_store')->nullable();
			$table->string('nik')->nullable();
			$table->string('fingerprint_id');
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
		Schema::drop('karyawan');
	}

}
