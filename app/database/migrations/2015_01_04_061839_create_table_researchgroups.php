<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableResearchgroups extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
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
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('researchgroups');
	}

}
