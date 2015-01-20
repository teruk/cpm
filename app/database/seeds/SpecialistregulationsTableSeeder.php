<?php
class SpecialistregulationsTableSeeder extends Seeder 
{
	
	public function run()
	{
		$specialistregulations = array(
				['degreecourse_id' => '1' , 'turn_id' => '2', 'description' => 'Ermöglicht den Studierenden viele Freiheiten und noch viel mehr.', 'active' => 1],
				['degreecourse_id' => '2' , 'turn_id' => '2', 'description' => 'Ermöglicht den Studierenden viele Freiheiten und noch viel mehr.', 'active' => 0],
				['degreecourse_id' => '2' , 'turn_id' => '4', 'description' => 'Die FSBs sind viel besser als die Alten und werden das Studium zum Kinderspiel machen.', 'active' => 1],
				['degreecourse_id' => '3' , 'turn_id' => '1', 'description' => 'Ermöglicht den Studierenden viele Freiheiten und noch viel mehr.', 'active' => 1],
				['degreecourse_id' => '4' , 'turn_id' => '2', 'description' => 'Ermöglicht den Studierenden viele Freiheiten und noch viel mehr.', 'active' => 1],
				['degreecourse_id' => '5' , 'turn_id' => '3', 'description' => 'Ermöglicht den Studierenden viele Freiheiten und noch viel mehr.', 'active' => 1],
				['degreecourse_id' => '6' , 'turn_id' => '4', 'description' => 'Ermöglicht den Studierenden viele Freiheiten und noch viel mehr.', 'active' => 1],
				['degreecourse_id' => '9' , 'turn_id' => '2', 'description' => 'Ermöglicht den Studierenden viele Freiheiten und noch viel mehr.', 'active' => 1],
		);
		DB::table('specialistregulations')->insert($specialistregulations);
	}
}
