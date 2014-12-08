<?php
use Illuminate\Database\Seeder;
class SectionsTableSeeder extends Seeder
{
	public function run()
	{
		$sections = array(
			['name' => 'Pflicht', 		'created_at' => new DateTime, 'updated_at' => new DateTime],
			['name' => 'Wahlpflicht', 	'created_at' => new DateTime, 'updated_at' => new DateTime],
			['name' => 'Vertiefung', 	'created_at' => new DateTime, 'updated_at' => new DateTime],
			['name' => 'Freie Wahl', 	'created_at' => new DateTime, 'updated_at' => new DateTime],
		);
		
		DB::table('sections')->insert($sections);
	}
}