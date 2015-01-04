<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCourses extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('courses', function (Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('name_eng');
			$table->string('course_number');
			$table->integer('coursetype_id')->unsigned()->index();
			$table->foreign('coursetype_id')->references('id')->on('coursetypes')->onDelete('cascade');
			$table->integer('module_id')->unsigned()->index();
			$table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
			$table->integer('participants');
			$table->integer('language');
			$table->float('semester_periods_per_week');
			$table->integer('department_id')->unsigned()->index();
			$table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
			$table->unique('course_number');
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
		Schema::drop('courses');
	}

}
