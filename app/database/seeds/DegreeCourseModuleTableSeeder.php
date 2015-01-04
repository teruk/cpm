<?php
/*
 * Schema::create('degree_course_module', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('degreecourse_id')->unsigned()->index();
			$table->foreign('degreecourse_id')->references('id')->on('degree_courses')->onDelete('cascade');
			$table->integer('module_id')->unsigned()->index();
			$table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
			$table->integer('semester');
			$table->integer('section');
			$table->timestamps();
		});
 */
class DegreeCourseModuleTableSeeder extends Seeder {

	public function run()
	{
		$degree_course_module = array(
			['degreecourse_id' => 1, 'module_id' => 1, 'semester' => 1, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 1, 'module_id' => 2, 'semester' => 2, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 1, 'module_id' => 3, 'semester' => 2, 'section' => 2, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 1, 'module_id' => 4, 'semester' => 3, 'section' => 2, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 2, 'module_id' => 1, 'semester' => 1, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 8, 'module_id' => 4, 'semester' => 1, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 5, 'module_id' => 1, 'semester' => 1, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 4, 'module_id' => 1, 'semester' => 1, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 3, 'module_id' => 1, 'semester' => 1, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 3, 'module_id' => 17, 'semester' => 1, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 1, 'module_id' => 17, 'semester' => 1, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 1, 'module_id' => 9, 'semester' => 1, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 2, 'module_id' => 9, 'semester' => 1, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 4, 'module_id' => 9, 'semester' => 1, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 3, 'module_id' => 9, 'semester' => 1, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 3, 'module_id' => 2, 'semester' => 2, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 4, 'module_id' => 2, 'semester' => 2, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 5, 'module_id' => 2, 'semester' => 4, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 2, 'module_id' => 2, 'semester' => 2, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 2, 'module_id' => 10, 'semester' => 1, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 2, 'module_id' => 35, 'semester' => 1, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 1, 'module_id' => 5, 'semester' => 2, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 2, 'module_id' => 5, 'semester' => 4, 'section' => 2, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 5, 'module_id' => 5, 'semester' => 2, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 4, 'module_id' => 5, 'semester' => 2, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 3, 'module_id' => 5, 'semester' => 2, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 1, 'module_id' => 90, 'semester' => 1, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 2, 'module_id' => 90, 'semester' => 1, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 3, 'module_id' => 90, 'semester' => 1, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 1, 'module_id' => 91, 'semester' => 2, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 2, 'module_id' => 91, 'semester' => 2, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 3, 'module_id' => 91, 'semester' => 2, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 4, 'module_id' => 90, 'semester' => 1, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 1, 'module_id' => 18, 'semester' => 2, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 2, 'module_id' => 18, 'semester' => 2, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 4, 'module_id' => 18, 'semester' => 3, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 3, 'module_id' => 18, 'semester' => 2, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 1, 'module_id' => 15, 'semester' => 3, 'section' => 2, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 2, 'module_id' => 15, 'semester' => 3, 'section' => 2, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 5, 'module_id' => 15, 'semester' => 3, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 4, 'module_id' => 15, 'semester' => 5, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 3, 'module_id' => 15, 'semester' => 3, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 3, 'module_id' => 20, 'semester' => 3, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 3, 'module_id' => 22, 'semester' => 3, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 1, 'module_id' => 16, 'semester' => 3, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 5, 'module_id' => 16, 'semester' => 3, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 2, 'module_id' => 18, 'semester' => 3, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 2, 'module_id' => 34, 'semester' => 3, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 2, 'module_id' => 32, 'semester' => 3, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 2, 'module_id' => 37, 'semester' => 3, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 2, 'module_id' => 23, 'semester' => 5, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 2, 'module_id' => 23, 'semester' => 6, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 2, 'module_id' => 16, 'semester' => 5, 'section' => 2, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 2, 'module_id' => 5, 'semester' => 2, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 2, 'module_id' => 6, 'semester' => 5, 'section' => 2, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 2, 'module_id' => 15, 'semester' => 5, 'section' => 2, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 2, 'module_id' => 11, 'semester' => 4, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 2, 'module_id' => 11, 'semester' => 6, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 2, 'module_id' => 14, 'semester' => 5, 'section' => 2, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 2, 'module_id' => 8, 'semester' => 6, 'section' => 2, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 2, 'module_id' => 22, 'semester' => 3, 'section' => 2, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 2, 'module_id' => 22, 'semester' => 5, 'section' => 2, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 2, 'module_id' => 17, 'semester' => 3, 'section' => 2, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 2, 'module_id' => 17, 'semester' => 5, 'section' => 2, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 2, 'module_id' => 3, 'semester' => 3, 'section' => 2, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 2, 'module_id' => 3, 'semester' => 5, 'section' => 2, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 2, 'module_id' => 4, 'semester' => 3, 'section' => 2, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 2, 'module_id' => 4, 'semester' => 5, 'section' => 2, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 2, 'module_id' => 7, 'semester' => 4, 'section' => 2, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 2, 'module_id' => 7, 'semester' => 5, 'section' => 2, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 1, 'module_id' => 13, 'semester' => 4, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 2, 'module_id' => 13, 'semester' => 4, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 1, 'module_id' => 7, 'semester' => 5, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 1, 'module_id' => 12, 'semester' => 5, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 1, 'module_id' => 12, 'semester' => 6, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 6, 'module_id' => 42, 'semester' => 1, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 6, 'module_id' => 42, 'semester' => 2, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 6, 'module_id' => 58, 'semester' => 2, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 6, 'module_id' => 58, 'semester' => 3, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 9, 'module_id' => 65, 'semester' => 1, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 9, 'module_id' => 66, 'semester' => 1, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 9, 'module_id' => 62, 'semester' => 1, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 9, 'module_id' => 63, 'semester' => 3, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 9, 'module_id' => 86, 'semester' => 3, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
			['degreecourse_id' => 9, 'module_id' => 64, 'semester' => 3, 'section' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],
		);

		// Uncomment the below to run the seeder
		DB::table('degreecourse_module')->insert($degree_course_module);
	}

}