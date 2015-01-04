<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCoursetypes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('coursetypes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('short');
			$table->string('description');
			$table->unique('name','short');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('coursetypes');
	}

}
