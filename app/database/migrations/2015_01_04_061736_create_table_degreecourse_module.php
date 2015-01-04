<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDegreeCourseModule extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('degreecourse_module', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('degreecourse_id')->unsigned()->index();
			$table->foreign('degreecourse_id')->references('id')->on('degreecourses')->onDelete('cascade');
			$table->integer('module_id')->unsigned()->index();
			$table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
			$table->integer('semester');
			$table->integer('section');
			$table->unique(array('degreecourse_id','module_id','semester'));
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
		Schema::drop('degreecourse_module');
	}

}
