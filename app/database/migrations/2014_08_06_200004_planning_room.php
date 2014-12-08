<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PlanningRoom extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('planning_room', function (Blueprint $table)
		{
			$table->increments('id');
			$table->integer('planning_id')->unsigned()->index();
			$table->foreign('planning_id')->references('id')->on('plannings')->onDelete('cascade');
			$table->integer('room_id')->unsigned()->index();
			$table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
			$table->integer('weekday');
			$table->time('start_time');
			$table->time('end_time');
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
		Schema::drop('planning_room');
	}

}
