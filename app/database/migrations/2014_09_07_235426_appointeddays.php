<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Appointeddays extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('appointeddays', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('subject');
			$table->string('read_more');
			$table->text('content');
			$table->timestamp('date');
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
		Schema::drop('appointeddays');
	}

}
