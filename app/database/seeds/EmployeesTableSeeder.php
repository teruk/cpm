<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class EmployeesTableSeeder extends Seeder {
	
	public function run()
	{
		$faker = Faker::create();

		foreach (range(1,100) as $index) {
			Employee::create([
				'name' => $faker->lastname,
				'firstname' => $faker->firstname(),
				'title' => $faker->randomElement(['Dr.', 'Prof. Dr.', 'Prof. Dr.-Ing.', '']),
				'researchgroup_id' => $faker->numberBetween(1,22),
				'teaching_load' => $faker->numberBetween(1,9),
				'employed_since' => $faker->dateTimeThisDecade(),
				'employed_till' => 2016-12-12
				]);
		}

		$employees = array(
			['name' => 'KOGS', 'firstname' => 'N.N.', 'title' => '', 'researchgroup_id' => '3', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'NATS', 'firstname' => 'N.N.', 'title' => '', 'researchgroup_id' => '2', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'TAMS', 'firstname' => 'N.N.', 'title' => '', 'researchgroup_id' => '4', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'WSV', 'firstname' => 'N.N.', 'title' => '', 'researchgroup_id' => '5', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'WTM', 'firstname' => 'N.N.', 'title' => '', 'researchgroup_id' => '6', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'ISYS', 'firstname' => 'N.N.', 'title' => '', 'researchgroup_id' => '7', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'ITG', 'firstname' => 'N.N.', 'title' => '', 'researchgroup_id' => '8', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'ITMC', 'firstname' => 'N.N.', 'title' => '', 'researchgroup_id' => '9', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'MBS', 'firstname' => 'N.N.', 'title' => '', 'researchgroup_id' => '10', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'MOBIS', 'firstname' => 'N.N.', 'title' => '', 'researchgroup_id' => '11', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'SVS', 'firstname' => 'N.N.', 'title' => '', 'researchgroup_id' => '12', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'SWT', 'firstname' => 'N.N.', 'title' => '', 'researchgroup_id' => '13', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'SWK', 'firstname' => 'N.N.', 'title' => '', 'researchgroup_id' => '14', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'TGI', 'firstname' => 'N.N.', 'title' => '', 'researchgroup_id' => '15', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'TKRN', 'firstname' => 'N.N.', 'title' => '', 'researchgroup_id' => '16', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'VSYS', 'firstname' => 'N.N.', 'title' => '', 'researchgroup_id' => '17', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'AMD', 'firstname' => 'N.N.', 'title' => '', 'researchgroup_id' => '18', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'ML', 'firstname' => 'N.N.', 'title' => '', 'researchgroup_id' => '19', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'WR', 'firstname' => 'N.N.', 'title' => '', 'researchgroup_id' => '20', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'WVP', 'firstname' => 'N.N.', 'title' => '', 'researchgroup_id' => '21', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'ASI', 'firstname' => 'N.N.', 'title' => '', 'researchgroup_id' => '22', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'KOGS', 'firstname' => 'SHK', 'title' => '', 'researchgroup_id' => '3', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'NATS', 'firstname' => 'SHK', 'title' => '', 'researchgroup_id' => '2', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'TAMS', 'firstname' => 'SHK', 'title' => '', 'researchgroup_id' => '4', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'WSV', 'firstname' => 'SHK', 'title' => '', 'researchgroup_id' => '5', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'WTM', 'firstname' => 'SHK', 'title' => '', 'researchgroup_id' => '6', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'ISYS', 'firstname' => 'SHK', 'title' => '', 'researchgroup_id' => '7', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'ITG', 'firstname' => 'SHK', 'title' => '', 'researchgroup_id' => '8', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'ITMC', 'firstname' => 'SHK', 'title' => '', 'researchgroup_id' => '9', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'MBS', 'firstname' => 'SHK', 'title' => '', 'researchgroup_id' => '10', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'MOBIS', 'firstname' => 'SHK', 'title' => '', 'researchgroup_id' => '11', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'SVS', 'firstname' => 'SHK', 'title' => '', 'researchgroup_id' => '12', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'SWT', 'firstname' => 'SHK', 'title' => '', 'researchgroup_id' => '13', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'SWK', 'firstname' => 'SHK', 'title' => '', 'researchgroup_id' => '14', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'TGI', 'firstname' => 'SHK', 'title' => '', 'researchgroup_id' => '15', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'TKRN', 'firstname' => 'SHK', 'title' => '', 'researchgroup_id' => '16', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'VSYS', 'firstname' => 'SHK', 'title' => '', 'researchgroup_id' => '17', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'AMD', 'firstname' => 'SHK', 'title' => '', 'researchgroup_id' => '18', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'ML', 'firstname' => 'SHK', 'title' => '', 'researchgroup_id' => '19', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'WR', 'firstname' => 'SHK', 'title' => '', 'researchgroup_id' => '20', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'WVP', 'firstname' => 'SHK', 'title' => '', 'researchgroup_id' => '21', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'ASI', 'firstname' => 'SHK', 'title' => '', 'researchgroup_id' => '22', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
			['name' => 'MCI', 'firstname' => 'SHK', 'title' => '', 'researchgroup_id' => '1', 'teaching_load' => 0, 'employed_since' => 2000-01-01, 'employed_till' => 2000-01-01 ],
		);
		DB::table('employees')->insert($employees);
	}
}