<?php
use Illuminate\Database\Seeder;
class ResearchgroupUserTableSeeder extends Seeder
{
	public function run()
	{
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