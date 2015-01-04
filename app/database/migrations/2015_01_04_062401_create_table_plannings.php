<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePlannings extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('plannings', function (Blueprint $table)
		{
			$table->increments('id');
			$table->integer('turn_id')->unsigned()->index();
			$table->foreign('turn_id')->references('id')->on('turns')->onDelete('cascade');
			$table->integer('course_id')->unsigned()->index();
			$table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
			$table->integer('group_number');
			$table->integer('researchgroup_status');
			$table->integer('board_status');
			$table->integer('language');
			$table->string('course_number');
			$table->string('course_title');
			$table->string('course_title_eng');
			$table->float('semester_periods_per_week');
			$table->integer('user_id')->unsigned()->index();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->boolean('teaching_assignment');
			$table->text('comment');
			$table->text('room_preference');
			$table->unique(array('course_id','turn_id','group_number','course_number'));
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
		Schema::drop('plannings');
	}

}
