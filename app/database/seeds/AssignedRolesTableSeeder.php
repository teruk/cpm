<?php
use Illuminate\Database\Seeder;
class AssignedRolesTableSeeder extends Seeder
{
	public function run()
	{
		$assigned_roles = array(
				['user_id' => 1, 'role_id' => 1],
				['user_id' => 2, 'role_id' => 2],
				['user_id' => 3, 'role_id' => 3],
				['user_id' => 4, 'role_id' => 4],
				['user_id' => 5, 'role_id' => 4],
				['user_id' => 6, 'role_id' => 4],
				['user_id' => 7, 'role_id' => 4],
		);
		DB::table('assigned_roles')->insert($assigned_roles);
	}
}
