<?php

class UsersTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('users')->delete();
		$users = array(
				['name' => 'Administrator', 'email' => 'admin@lpm.de', 'password' => Hash::make('lpmtestpasswort'), 'deactivated' => 0, 'last_login' => new Datetime],
				['name' => 'LehplanerIn', 'email' => 'lp@lpm.de', 'password' => Hash::make('lpmtestpasswort'), 'deactivated' => 0, 'last_login' => new Datetime],
				['name' => 'RaumplanerIn', 'email' => 'rp@lpm.de', 'password' => Hash::make('lpmtestpasswort'), 'deactivated' => 0, 'last_login' => new Datetime],
				['name' => 'Hans Müller', 'email' => 'hm@lpm.de', 'password' => Hash::make('lpmtestpasswort'), 'deactivated' => 0, 'last_login' => new Datetime],
				['name' => 'Sabine Schulz', 'email' => 'ss@lpm.de', 'password' => Hash::make('lpmtestpasswort'), 'deactivated' => 0, 'last_login' => new Datetime],
				['name' => 'Klaus Peter', 'email' => 'kp@lpm.de', 'password' => Hash::make('lpmtestpasswort'), 'deactivated' => 0, 'last_login' => new Datetime],
				['name' => 'Lokale/r TestplanerIn', 'email' => 'test@lpm.de', 'password' => Hash::make('lpmtestpasswort'), 'deactivated' => 0, 'last_login' => new Datetime],
		);
		DB::table('users')->insert($users);

		DB::table('assigned_roles')->delete();
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

		DB::table('researchgroup_user')->delete();
		$researchgroup_user = array(
				['researchgroup_id' => 1, 'user_id' => 2],
				['researchgroup_id' => 2, 'user_id' => 2],
				['researchgroup_id' => 3, 'user_id' => 2],
				['researchgroup_id' => 4, 'user_id' => 2],
				['researchgroup_id' => 5, 'user_id' => 2],
				['researchgroup_id' => 6, 'user_id' => 2],
				['researchgroup_id' => 7, 'user_id' => 2],
				['researchgroup_id' => 8, 'user_id' => 2],
				['researchgroup_id' => 9, 'user_id' => 2],
				['researchgroup_id' => 10, 'user_id' => 2],
				['researchgroup_id' => 11, 'user_id' => 2],
				['researchgroup_id' => 12, 'user_id' => 2],
				['researchgroup_id' => 13, 'user_id' => 2],
				['researchgroup_id' => 14, 'user_id' => 2],
				['researchgroup_id' => 15, 'user_id' => 2],
				['researchgroup_id' => 16, 'user_id' => 2],
				['researchgroup_id' => 17, 'user_id' => 2],
				['researchgroup_id' => 18, 'user_id' => 2],
				['researchgroup_id' => 19, 'user_id' => 2],
				['researchgroup_id' => 20, 'user_id' => 2],
				['researchgroup_id' => 21, 'user_id' => 2],
				['researchgroup_id' => 22, 'user_id' => 2],
				['researchgroup_id' => 1, 'user_id' => 4],
				['researchgroup_id' => 5, 'user_id' => 4],
				['researchgroup_id' => 2, 'user_id' => 5],
				['researchgroup_id' => 19, 'user_id' => 5],
				['researchgroup_id' => 3, 'user_id' => 6],
				['researchgroup_id' => 8, 'user_id' => 7],
				['researchgroup_id' => 9, 'user_id' => 7],
		);
		DB::table('researchgroup_user')->insert($researchgroup_user);
	}
}