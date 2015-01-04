<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableModules extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
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
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('modules');
	}

}
