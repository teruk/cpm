<?php
use Illuminate\Database\Seeder;
class AnnouncementsTableSeeder extends Seeder
{
	public function run()
	{
		$announcements = [];
		
		DB::table('announcements')->insert($announcements);
	}
}