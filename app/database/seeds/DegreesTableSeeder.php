<?php
use Illuminate\Database\Seeder;
class DegreesTableSeeder extends Seeder
{
	public function run()
	{
		$degrees = array(
			['name' => 'Bachelor',	'created_at' => new DateTime, 'updated_at' => new DateTime],
			['name' => 'Master', 	'created_at' => new DateTime, 'updated_at' => new DateTime],
			['name' => 'Diplom',  	'created_at' => new DateTime, 'updated_at' => new DateTime],
			['name' => 'Magister', 	'created_at' => new DateTime, 'updated_at' => new DateTime],
		);
		
		DB::table('degrees')->insert($degrees);
	}
}