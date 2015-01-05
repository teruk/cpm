<?php

class GenerateMediumtermplanningsController extends \BaseController {

	/**
	 * generates planning from medium term planning for a specific turn
	 * @param  Turn   $turn [description]
	 * @return [type]       [description]
	 */
	public function generatePlannings(Turn $turn)
	{
		// nice midtermplannings scopeModules(Turn turn), but mediumterms have to be changed for that
		if (Entrust::hasRole('Admin') || Entrust::can('generate_planning_midterm_all')) // role Lehrplanung has to be changed to a permission
			$mediumtermplannings = Mediumtermplanning::specificTurn($turn)->get();
		else
		{
			// fetch medium term planning which belong to the research group
			$rg_ids = Entrust::user()->researchgroupIds();
			$mediumtermplanningIds = Mediumtermplanning::forSpecificResearchGroups($turn, $rg_ids)->get();
		}
		$warnmessage = "Es konnten nicht alle Veranstaltungen aus der mittelfristige Lehrplanung kopiert werden,
					da diese bereits im aktuellen Semester geplant wurden.<br> Folgende Veranstaltungen konnten nicht kopiert werden: ";
		$module = "";

		if (sizeof($mediumtermplannings) > 0)
		{
			foreach ($mediumtermplannings as $mediumtermplanning)
			{
				// check if courses are already planned for this turn
				foreach ($mediumtermplanning->module->courses as $course)
				{
					if ($course->coursetype->name == "Vorlesung")
					{
						// $plannings = Planning::courseTurn($course,$turn)->get();					
						if (Planning::courseTurn($course,$turn)->count() == 0)
						{
							// the course isn't planned yet for this turn
							$planning = new Planning;
							$planning->generatePlanning($turn, $course, 1);

							// saving the planning
							$planning->save();

							// log
							$planninglog = new Planninglog();
							$planninglog->logGeneratedPlanning($planning, $turn);

							$turn = Turn::findOrFail($turn->id); // refresh turn to get the current modules()
							$turn->saveExam($planning->course->module);
							// check if there employees assigned to the module
							if ($mediumtermplanning->employees->count() > 0)
							{
								foreach ($mediumtermplanning->employees as $employee)
								{
									// if the employee is annulled, he/she can be left out
									if ($employee->pivot->annulled == 0)
									{
										$planning->employees()->attach($employee->id,array(
												'semester_periods_per_week' => 0,
										));
										// log
										$planninglog = new Planninglog();
										$planninglog->logAssignedPlanningEmployee($planning, $turn, $employee, 0);
									}
								}
							}
						}
						else
							$module .= $course->course_number.' ('.$mediumtermplanning->module->short.');';
					}
					
					else
					{
						// generate the number of courses that are needed to match the participant number of the lecture
						$lecture = Course::relatedLecture($course)->first();
						if (sizeof($lecture) > 0) 
						{
							$numberOfGroups = ceil($lecture->participants / $course->participants);
							for ($i=1; $i <= $numberOfGroups; $i++) 
							{ 
								// $plannings = Planning::courseTurnGroup($course,$turn,$i)->get();					
								if (Planning::courseTurnGroup($course,$turn,$i)->count() == 0)
								{
									// the course isn't planned yet for this turn
									$planning = new Planning;
									$planning->generatePlanning($turn, $course, $i);
									// saving the planning
									$planning->save();

									// log
									$planninglog = new Planninglog();
									$planninglog->logGeneratedPlanning($planning, $turn);

									$turn = Turn::findOrFail($turn->id); // refresh turn to get the current modules()
									$turn->saveExam($planning->course->module);
								}
								else
									$module .= $course->course_number.' ('.$mediumtermplanning->module->short.');';
							}
						}
						else
						{
							// $plannings = Planning::courseTurn($course,$turn)->get();					
							if (Planning::courseTurn($course,$turn)->count() == 0)
							{
								// the course isn't planned yet for this turn
								$planning = new Planning;
								$planning->generatePlanning($turn, $course, 1);

								// saving the planning
								$planning->save();

								// log
								$planninglog = new Planninglog();
								$planninglog->logGeneratedPlanning($planning, $turn);

								$turn = Turn::findOrFail($turn->id); // refresh turn to get the current modules()
								$turn->saveExam($planning->course->module);
								// check if there employees assigned to the module
								if (sizeof($mediumtermplanning->employees) > 0)
								{
									foreach ($mediumtermplanning->employees as $employee)
									{
										// if the employee is annulled, he/she can be left out
										if ($employee->pivot->annulled == 0)
										{
											$planning->employees()->attach($employee->id,array(
													'semester_periods_per_week' => 0,
											));
											// log
											$planninglog = new Planninglog();
											$planninglog->logAssignedPlanningEmployee($planning, $turn, $employee, 0);
										}
									}
								}
							}
							else
								$module .= $course->course_number.' ('.$mediumtermplanning->module->short.');';
						}
					}
				}
			}
			if ($module == "")
			{
				Flash::success('Lehrveranstaltungen erfolgreich aus der mittelfristigen Lehrplanung generiert.');
				return Redirect::back();
			}	
			
			Flash::error($warnmessage.''.$module);
			return Redirect::back();
		}
		
		Flash::error('Es existiert keine mittelfristige Planung für dieses Semester.');
		return Redirect::back();
		
	}
}
