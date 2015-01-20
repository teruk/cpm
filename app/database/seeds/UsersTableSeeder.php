<?php

class UsersTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('users')->delete();
		$users = array(
				['name' => 'Administrator', 'email' => 'admin@lpm.de', 'password' => Hash::make('passwort'), 'deactivated' => 0, 'last_login' => new Datetime],
				['name' => 'LehplanerIn', 'email' => 'lp@lpm.de', 'password' => Hash::make('passwort'), 'deactivated' => 0, 'last_login' => new Datetime],
				['name' => 'RaumplanerIn', 'email' => 'rp@lpm.de', 'password' => Hash::make('passwort'), 'deactivated' => 0, 'last_login' => new Datetime],
				['name' => 'Hans Müller', 'email' => 'hm@lpm.de', 'password' => Hash::make('passwort'), 'deactivated' => 0, 'last_login' => new Datetime],
				['name' => 'Sabine Schulz', 'email' => 'ss@lpm.de', 'password' => Hash::make('passwort'), 'deactivated' => 0, 'last_login' => new Datetime],
				['name' => 'Klaus Peter', 'email' => 'kp@lpm.de', 'password' => Hash::make('passwort'), 'deactivated' => 0, 'last_login' => new Datetime],
				['name' => 'Lokale/r TestplanerIn', 'email' => 'test@lpm.de', 'password' => Hash::make('passwort'), 'deactivated' => 0, 'last_login' => new Datetime],
		);
		DB::table('users')->insert($users);
	}
}
