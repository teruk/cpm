<?php
use Illuminate\Database\Seeder;
class AppointeddaysTableSeeder extends Seeder
{
	public function run()
	{
		$appointeddays = [];
		
		DB::table('appointeddays')->insert($appointeddays);
	}
}