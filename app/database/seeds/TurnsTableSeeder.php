<?php
class TurnsTableSeeder extends Seeder 
{	
	public function run()
	{
		$turns = array(
				['name' => 'SoSe', 'year' => 2013, 'semester_start' => '2013-04-01', 'semester_end' => '2013-07-14'],
				['name' => 'WiSe', 'year' => 2013, 'semester_start' => '2013-10-01', 'semester_end' => '2014-02-14'],
				['name' => 'SoSe', 'year' => 2014, 'semester_start' => '2014-04-01', 'semester_end' => '2014-07-14'],
				['name' => 'WiSe', 'year' => 2014, 'semester_start' => '2014-10-01', 'semester_end' => '2015-02-14'],
				['name' => 'SoSe', 'year' => 2015, 'semester_start' => '2015-04-01', 'semester_end' => '2015-07-14'],
				['name' => 'WiSe', 'year' => 2015, 'semester_start' => '2015-10-01', 'semester_end' => '2016-02-14'],
				['name' => 'SoSe', 'year' => 2016, 'semester_start' => '2016-04-01', 'semester_end' => '2016-07-14'],
				['name' => 'WiSe', 'year' => 2016, 'semester_start' => '2016-10-01', 'semester_end' => '2017-02-14'],
				['name' => 'SoSe', 'year' => 2017, 'semester_start' => '2017-04-01', 'semester_end' => '2017-07-14'],
				['name' => 'WiSe', 'year' => 2017, 'semester_start' => '2017-10-01', 'semester_end' => '2018-02-14'],
		);
		DB::table('turns')->insert($turns);
	}
}
