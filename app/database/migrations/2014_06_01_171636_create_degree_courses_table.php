<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDegreeCoursesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('degrees', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->unique();
			$table->timestamps();
		});
		
		Schema::create('sections', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->unique('name');
			$table->timestamps();
		});
		
		Schema::create('rotations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->unique('name');
			$table->timestamps();
		});
		
		Schema::create('departments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('short');
			$table->unique(array('name','short'));
			$table->timestamps();
		});
		
		Schema::create('turns', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->integer('year');
			$table->date('semester_start');
			$table->date('semester_end');
			$table->unique(array('name','year'));
		});
		
		Schema::create('degree_courses', function(Blueprint $table)
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
		
		Schema::create('modules', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('short')->unique();
			$table->string('name_eng');
			$table->float('credits');
			$table->integer('exam_type');
			$table->integer('rotation_id')->unsigned()->index();
			$table->foreign('rotation_id')->references('id')->on('rotations')->onDelete('cascade');
			$table->integer('language');
			$table->integer('degree_id')->unsigned()->index();
			$table->foreign('degree_id')->references('id')->on('degrees')->onDelete('cascade');
			$table->integer('department_id')->unsigned()->index();
			$table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
			$table->boolean('individual_courses');
			$table->timestamps();
		});
		
		Schema::create('degree_course_module', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('degree_course_id')->unsigned()->index();
			$table->foreign('degree_course_id')->references('id')->on('degree_courses')->onDelete('cascade');
			$table->integer('module_id')->unsigned()->index();
			$table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
			$table->integer('semester');
			$table->integer('section');
			$table->unique(array('degree_course_id','module_id','semester'));
			$table->timestamps();
		});
		
		Schema::create('researchgroups', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('short');
			// 			$table->integer('employee_id')->unsigned->index();
			// 			$table->foreign('employee_id')->reference('id')->on('employees')->onDelete('cascade');
			$table->integer('department_id')->unsigned()->index();
			$table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
			$table->unique('name');
			$table->timestamps();
		});
		
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
		
		Schema::create('room_types', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('description');
			$table->unique('name');
		});
		
		Schema::create('rooms', function (Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('location');
			$table->integer('seats');
			$table->integer('room_type_id')->unsigned()->index();
			$table->foreign('room_type_id')->references('id')->on('room_types')->onDelete('cascade');
			$table->boolean('beamer');
			$table->boolean('blackboard');
			$table->boolean('overheadprojector');
			$table->boolean('accessible');
			$table->unique(array('name','location'));
		});
		
		Schema::create('course_types', function(Blueprint $table)
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
		Schema::drop('employees');
		Schema::drop('researchgroups');
		Schema::drop('degree_course_module');
		Schema::drop('modules');
		Schema::drop('degree_courses');
		Schema::drop('departments');
		Schema::drop('turns');
		Schema::drop('rotations');
		Schema::drop('sections');
		Schema::drop('degrees');
		Schema::drop('course_types');
		Schema::drop('rooms');
		Schema::drop('room_types');
	}

}
