<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableModuleSpecialistregulation extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('module_specialistregulation', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('specialistregulation_id')->unsigned()->index();
			$table->foreign('specialistregulation_id')->references('id')->on('specialistregulations')->onDelete('cascade');
			$table->integer('module_id')->unsigned()->index();
			$table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
			$table->integer('semester');
			$table->integer('section');
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
		Schema::drop('module_specialistregulation');
	}

}
