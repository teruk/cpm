<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTurns extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('turns', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->integer('year');
			$table->date('semester_start');
			$table->date('semester_end');
			$table->unique(array('name','year'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('turns');
	}

}
