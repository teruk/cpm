<?php
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AnnouncementsTableSeeder extends Seeder
{
	public function run()
	{
		$faker = Faker::create();

		foreach (range(1,4) as $index) {
			$content = $faker->realText(400, 2);
			$readMore = (strlen($content) > 120) ? substr($content, 0, 120) : $content;
			Announcement::create([
				'subject' => $faker->catchPhrase(),
				'content' => $content,
				'read_more' => $readMore,
				'user_id' => $faker->numberBetween(1,2)
				]);
		}
	}
}