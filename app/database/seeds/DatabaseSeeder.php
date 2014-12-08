<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		$this->call('DegreesTableSeeder');
		$this->call('SettingsTableSeeder');
		$this->call('SectionsTableSeeder');
		$this->call('RotationsTableSeeder');
		$this->call('RoomTypesTableSeeder');
		$this->call('DepartmentsTableSeeder');
		$this->call('TurnsTableSeeder');
		$this->call('ModulesTableSeeder');
		$this->call('DegreeCoursesTableSeeder');
		$this->call('DegreeCourseModuleTableSeeder');
		$this->call('ResearchGroupsTableSeeder');
		$this->call('EmployeesTableSeeder');
		$this->call('MediumtermplanningsTableSeeder');
		$this->call('RoomsTableSeeder');
		$this->call('CourseTypesTableSeeder');
		$this->call('CoursesTableSeeder');
		$this->call('PermissionsTableSeeder'); // order is important, permissions seeder has to run before roles
		$this->call('RolesTableSeeder'); // roles seeder has to run before users
		$this->call('UsersTableSeeder');
		$this->call('PlanningsTableSeeder');
	}

}
