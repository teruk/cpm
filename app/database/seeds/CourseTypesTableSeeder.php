<?php
use Illuminate\Database\Seeder;
class CourseTypesTableSeeder extends Seeder
{
	public function run()
	{
		$coursetypes = array(
			['name' => 'Vorlesung', 'short' => 'VL', 'description' => ''],
			['name' => 'Seminar', 'short' => 'Sem', 'description' => ''],
			['name' => 'Integriertes Seminar', 'short' => 'IS', 'description' => ''],
			['name' => 'Übung', 'short' => 'Üb', 'description' => ''],
			['name' => 'Proseminar', 'short' => 'PS', 'description' => ''],
			['name' => 'Projekt', 'short' => 'Proj', 'description' => ''],
			['name' => 'Praktikum', 'short' => 'Prak', 'description' => ''],
			['name' => 'Vorlesung + Übung', 'short' => 'VL+Üb', 'description' => ''],
			['name' => 'Tutorium', 'short' => 'Tut', 'description' => ''],
			['name' => 'Anleitung', 'short' => 'Anl', 'description' => ''],
			['name' => 'Sonstiges', 'short' => 'Sonst', 'description' => ''],
		);
		
		DB::table('coursetypes')->insert($coursetypes);
	}
}
