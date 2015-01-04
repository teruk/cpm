<?php
use Illuminate\Database\Seeder;
class RoomTypesTableSeeder extends Seeder
{
	public function run()
	{
		$roomtypes = array(
			['name' => 'Hörsaal', 'description' => ''],
			['name' => 'Seminarraum', 'description' => ''],
			['name' => 'Computerraum', 'description' => ''],
			['name' => 'Labor', 'description' => ''],
		);
		
		DB::table('roomtypes')->insert($roomtypes);
	}
}