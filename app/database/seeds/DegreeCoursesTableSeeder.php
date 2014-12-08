<?php

class DegreeCoursesTableSeeder extends Seeder {

	public function run()
	{
		$degree_courses = array(
				['name' => 'Informatik', 					'short' => 'Inf BSc', 		'degree_id' => 1, 'department_id' => 1, 'created_at' =>  new DateTime, 'updated_at' => new DateTime],
				['name' => 'Wirtschaftsinformatik', 		'short' => 'WiInf BSc', 	'degree_id' => 1, 'department_id' => 1, 'created_at' =>  new DateTime, 'updated_at' => new DateTime],
				['name' => 'Software-System-Entwicklung', 	'short' => 'SSE BSc', 		'degree_id' => 1, 'department_id' => 1, 'created_at' =>  new DateTime, 'updated_at' => new DateTime],
				['name' => 'Mensch-Computer-Interaktion',  	'short' => 'MCI BSc', 		'degree_id' => 1, 'department_id' => 1, 'created_at' =>  new DateTime, 'updated_at' => new DateTime],
				['name' => 'Computing in Science',  		'short' => 'CiS BSc', 		'degree_id' => 1, 'department_id' => 1, 'created_at' =>  new DateTime, 'updated_at' => new DateTime],
				['name' => 'Informatik', 					'short' => 'Inf MSc', 		'degree_id' => 2, 'department_id' => 1, 'created_at' =>  new DateTime, 'updated_at' => new DateTime],
				['name' => 'Wirtschaftsinformatik', 		'short' => 'WiInf MSc', 	'degree_id' => 2, 'department_id' => 1, 'created_at' =>  new DateTime, 'updated_at' => new DateTime],
				['name' => 'Bioinformatik', 				'short' => 'BioInf MSc', 	'degree_id' => 2, 'department_id' => 1, 'created_at' =>  new DateTime, 'updated_at' => new DateTime],
				['name' => 'IT-Management und -Consulting', 'short' => 'ITMC MSc', 		'degree_id' => 2, 'department_id' => 1, 'created_at' =>  new DateTime, 'updated_at' => new DateTime],
				['name' => 'Intelligent Adaptive Systems', 	'short' => 'IAS MSc', 		'degree_id' => 2, 'department_id' => 1, 'created_at' =>  new DateTime, 'updated_at' => new DateTime],
		);
		
		// Uncomment the below to run the seeder
		DB::table('degree_courses')->insert($degree_courses);
	}

}