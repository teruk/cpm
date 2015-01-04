<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDegreecourses extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('degreecourses', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('short');
			$table->integer('degree_id')->unsigned()->index();
			$table->foreign('degree_id')->references('id')->on('degrees')->onDelete('cascade');
			$table->integer('department_id')->unsigned()->index();
			$table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
			$table->unique(array('name','degree_id'));
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
		Schema::drop('degreecourses');
	}

}
