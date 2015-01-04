<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableResearchgroupUser extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('researchgroup_user', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('researchgroup_id')->unsigned()->index();
			$table->foreign('researchgroup_id')->references('id')->on('researchgroups')->onDelete('cascade');
			$table->integer('user_id')->unsigned()->index();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->unique(array('researchgroup_id','user_id'));
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
		Schema::drop('researchgroup_user');
	}

}
