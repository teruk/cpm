<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableModuleTurn extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
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
	}

}
