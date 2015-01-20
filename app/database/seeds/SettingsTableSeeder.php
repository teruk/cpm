<?php
use Illuminate\Database\Seeder;
class SettingsTableSeeder extends Seeder
{
	public function run()
	{
		$settings = array(
			['name' => 'current_turn', 'display_name' => 'Aktuelles Semester', 'value' => 4],
		);
		
		DB::table('settings')->insert($settings);
	}
}
