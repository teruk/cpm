<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Specialistregulations extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('specialistregulations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('degreecourse_id')->unsigned()->index();
			$table->foreign('degreecourse_id')->references('id')->on('degreecourses')->onDelete('cascade');
			$table->integer('turn_id')->unsigned()->index();
			$table->foreign('turn_id')->references('id')->on('turns')->onDelete('cascade');
			$table->text('description');
			$table->boolean('active');
			$table->unique(['degreecourse_id', 'turn_id']);
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
		Schema::drop('specialistregulations');
	}

}
