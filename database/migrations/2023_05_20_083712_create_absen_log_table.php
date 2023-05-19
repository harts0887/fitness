<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAbsenLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('absen_log', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('site_code', 15)->nullable();
			$table->string('absen_code', 30)->unique()->nullable()->index('absen_log_absen_code_idx');
			$table->integer('mesin_number');
			$table->integer('pin');
			$table->timestamp('date_time');
			$table->integer('ver');
			$table->integer('status_absen_id');
			$table->timestamps();
			$table->timestamp('export_log')->nullable();
			$table->string('get_nik',30);
			$table->date('tanggal');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('absen_log');
	}

}
