<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEmployeePlanning extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
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
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('employee_planning');
	}

}
