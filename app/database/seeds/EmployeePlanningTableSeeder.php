<?php
use Illuminate\Database\Seeder;
class EmployeePlanningTableSeeder extends Seeder
{
	public function run()
	{
		$employee_planning = array(
			['planning_id' => 54, 'employee_id' => 54,'semester_periods_per_week' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['planning_id' => 55, 'employee_id' => 55,'semester_periods_per_week' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['planning_id' => 56, 'employee_id' => 56,'semester_periods_per_week' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['planning_id' => 57, 'employee_id' => 57,'semester_periods_per_week' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['planning_id' => 58, 'employee_id' => 58,'semester_periods_per_week' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['planning_id' => 59, 'employee_id' => 59,'semester_periods_per_week' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['planning_id' => 19, 'employee_id' => 19,'semester_periods_per_week' => 2, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['planning_id' => 53, 'employee_id' => 53,'semester_periods_per_week' => 3, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['planning_id' => 63, 'employee_id' => 63,'semester_periods_per_week' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['planning_id' => 64, 'employee_id' => 64,'semester_periods_per_week' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['planning_id' => 60, 'employee_id' => 60,'semester_periods_per_week' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['planning_id' => 61, 'employee_id' => 61,'semester_periods_per_week' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['planning_id' => 62, 'employee_id' => 62,'semester_periods_per_week' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['planning_id' => 1, 'employee_id' => 1,'semester_periods_per_week' => 2, 'created_at' => new DateTime, 'updated_at' => new DateTime],
		);
		DB::table('employee_planning')->insert($employee_planning);
	}
}