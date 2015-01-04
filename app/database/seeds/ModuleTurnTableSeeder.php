<?php
use Illuminate\Database\Seeder;
class ModuleTurnTableSeeder extends Seeder
{
	public function run()
	{
		$module_turn = array(
			['module_id' => 16, 'turn_id' => 4, 'exam' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['module_id' => 4, 'turn_id' => 4, 'exam' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['module_id' => 9, 'turn_id' => 4, 'exam' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['module_id' => 6, 'turn_id' => 4, 'exam' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['module_id' => 13, 'turn_id' => 4, 'exam' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['module_id' => 18, 'turn_id' => 4, 'exam' => 2, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['module_id' => 17, 'turn_id' => 4, 'exam' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['module_id' => 1, 'turn_id' => 4, 'exam' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['module_id' => 7, 'turn_id' => 4, 'exam' => 2, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['module_id' => 58, 'turn_id' => 4, 'exam' => 2, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['module_id' => 65, 'turn_id' => 4, 'exam' => 2, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['module_id' => 15, 'turn_id' => 4, 'exam' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['module_id' => 15, 'turn_id' => 6, 'exam' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			);
		// Uncomment the below to run the seeder
		DB::table('module_turn')->insert($module_turn);
	}
}