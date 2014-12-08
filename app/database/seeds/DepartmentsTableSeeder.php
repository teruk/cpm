<?php
/*
 * Schema::create('departments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('short');
			$table->unique(array('name','short'));
			$table->timestamps();
		});
 */
use Illuminate\Database\Seeder;
class DepartmentsTableSeeder extends Seeder
{
	public function run()
	{
		$departments = array(
			['name' => 'Informatik', 				'short' => 'Inf', 	'created_at' => new DateTime, 'updated_at' => new DateTime],
			['name' => 'Betriebswirtschaft', 		'short' => 'BWL', 	'created_at' => new DateTime, 'updated_at' => new DateTime],
			['name' => 'Mathematik', 				'short' => 'Mathe', 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['name' => 'Chemie', 					'short' => 'Che', 	'created_at' => new DateTime, 'updated_at' => new DateTime],
			['name' => 'Physik', 					'short' => 'Phy', 	'created_at' => new DateTime, 'updated_at' => new DateTime],
			['name' => 'Psychologie', 				'short' => 'Psy', 	'created_at' => new DateTime, 'updated_at' => new DateTime],
			['name' => 'Biologie', 					'short' => 'Bio', 	'created_at' => new DateTime, 'updated_at' => new DateTime],
		);
		
		DB::table('departments')->insert($departments);
	}
}