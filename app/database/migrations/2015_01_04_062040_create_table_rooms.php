<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRooms extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rooms', function (Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('location');
			$table->integer('seats');
			$table->integer('roomtype_id')->unsigned()->index();
			$table->foreign('roomtype_id')->references('id')->on('roomtypes')->onDelete('cascade');
			$table->boolean('beamer');
			$table->boolean('blackboard');
			$table->boolean('overheadprojector');
			$table->boolean('accessible');
			$table->unique(array('name','location'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('rooms');
	}

}
