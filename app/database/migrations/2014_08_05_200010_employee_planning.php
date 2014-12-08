<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EmployeePlanning extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name',32);
			$table->string('email',250);
			$table->string('password',64);
			$table->unique('email');
			$table->string('remember_token', 100)->nullable();
			$table->boolean('deactivated');
			$table->date('last_login');
			$table->timestamps();
		});

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
// 			$table->integer('rhythm');
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
		
		Schema::create('employee_planning', function (Blueprint $table)
		{
			$table->increments('id');
			$table->integer('planning_id')->unsigned()->index();
			$table->foreign('planning_id')->references('id')->on('plannings')->onDelete('cascade');
			$table->integer('employee_id')->unsigned()->index();
			$table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
			$table->float('semester_periods_per_week');
			$table->unique(array('employee_id','planning_id'));
			$table->timestamps();
		});

		Schema::create('module_turn', function (Blueprint $table)
		{
			$table->increments('id');
			$table->integer('module_id')->unsigned()->index();
			$table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
			$table->integer('turn_id')->unsigned()->index();
			$table->foreign('turn_id')->references('id')->on('turns')->onDelete('cascade');
			$table->integer('exam');
			$table->unique(array('turn_id','module_id'));
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
		Schema::drop('module_turn');
		Schema::drop('employee_planning');
		Schema::drop('plannings');
		Schema::drop('users');
	}

}
