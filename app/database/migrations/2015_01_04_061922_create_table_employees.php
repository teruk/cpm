<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEmployees extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('employees', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('firstname');
			$table->string('name');
			$table->string('title');
			$table->integer('researchgroup_id')->unsigned()->index();
			$table->foreign('researchgroup_id')->references('id')->on('researchgroups')->onDelete('cascade');
			$table->integer('teaching_load');
			$table->date('employed_since');
			$table->date('employed_till');
			$table->boolean('inactive');
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
		Schema::drop('employees');
	}

}
