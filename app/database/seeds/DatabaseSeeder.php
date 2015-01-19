<?php

class DatabaseSeeder extends Seeder {

	protected $tables = [
        'settings', 
        'degrees', 
        'sections',
        'rotations',
        'departments',
        'turns',
        'degreecourses',
        'modules',
        'degreecourse_module',
        'researchgroups',
        'employees',
        'roomtypes',
        'rooms',
        'coursetypes',
        'courses',
        'users',
        'plannings',
        'employee_planning',
        'module_turn',
        'planning_room',
        'mediumtermplannings',
        'employee_mediumtermplanning',
        'permissions',
        'roles',
        'assigned_roles',
        'permission_role',
        'researchgroup_user',
        'appointeddays',
        'announcements',
        'planninglogs',
        'specialistregulations',
    ];

    protected $seeders = [
        'SettingsTableSeeder', 
        'DegreesTableSeeder', 
        'SectionsTableSeeder',
        'RotationsTableSeeder',
        'DepartmentsTableSeeder',
        'TurnsTableSeeder',
        'DegreeCoursesTableSeeder',
        'SpecialistregulationsTableSeeder',
        'ModulesTableSeeder',
        'ModuleSpecialistregulationTableSeeder',
        'ResearchGroupsTableSeeder',
        'EmployeesTableSeeder',
        'RoomTypesTableSeeder',
        'RoomsTableSeeder',
        'CourseTypesTableSeeder',
        'CoursesTableSeeder',
        'UsersTableSeeder',
        'PlanningsTableSeeder',
        'EmployeePlanningTableSeeder',
        'ModuleTurnTableSeeder',
        'PlanningRoomTableSeeder',
        'MediumtermplanningsTableSeeder',
        'EmployeeMediumtermplanningTableSeeder',
        'PermissionsTableSeeder',
        'RolesTableSeeder',
        'AssignedRolesTableSeeder',
        'PermissionRoleTableSeeder',
        'ResearchgroupUserTableSeeder',
        'PlanninglogsTableSeeder',
        'AnnouncementsTableSeeder',

    ];
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->cleanDatabase();

		foreach ($this->seeders as $seedClass)
        {
            $this->call($seedClass);
        }
	}

	/**
     * clean up the database
     */
    private function cleanDatabase()
    {
        // sets foreign key checks to zero
        // TODO: needs to removed before going live
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        foreach ($this->tables as $table)
        {
            DB::table($table)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

}
