<?php

use Illuminate\Database\Seeder;
class RotationsTableSeeder extends Seeder
{
	public function run()
	{
		$rotations = array(
			['name' => 'WiSe/SoSe', 		'created_at' => new DateTime, 'updated_at' => new DateTime],
			['name' => 'WiSe', 	'created_at' => new DateTime, 'updated_at' => new DateTime],
			['name' => 'SoSe', 	'created_at' => new DateTime, 'updated_at' => new DateTime],
		);
		
		DB::table('rotations')->insert($rotations);
	}
}