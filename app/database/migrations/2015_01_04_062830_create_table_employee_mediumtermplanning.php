<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEmployeeMediumtermplanning extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('employee_mediumtermplanning', function (Blueprint $table)
		{
			$table->increments('id');
			$table->integer('mediumtermplanning_id')->unsigned()->index();
			$table->foreign('mediumtermplanning_id')->references('id')->on('mediumtermplannings')->onDelete('cascade');
			$table->integer('employee_id')->unsigned()->index();
			$table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
			$table->float('semester_periods_per_week');
			$table->boolean('annulled');
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
		Schema::drop('employee_mediumtermplanning');
	}

}
