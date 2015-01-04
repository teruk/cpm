<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePlanninglogs extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('planninglogs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('planning_id');
			$table->integer('turn_id');
			$table->text('action');
			$table->integer('category');
			$table->integer('action_type');
			$table->string('username');
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
		Schema::drop('planninglogs');
	}

}
