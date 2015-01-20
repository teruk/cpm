<?php


use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
class ModulesController extends \BaseController 
{

	/**
	 * Display a listing of the resource.
	 * GET /modules
	 *
	 * @return Response
	 */
	public function index()
	{
		$modules = Module::all();
		// getting these lists to minimize the queries
		$listofdepartments = Department::orderBy('name','ASC')->lists('name','id');
		$listofrotations = Rotation::orderBy('name','ASC')->lists('name','id');
		$listofdegrees = Degree::orderBy('name','ASC')->lists('name','id');

		return View::make('modules.index', compact('modules', 'listofdepartments', 'listofdegrees', 'listofrotations'));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /modules
	 *
	 * @return Response
	 */
	public function store()
	{
		$module = new Module();
		$module->fill(Input::all());
		if (Input::has('individual_courses'))
			$module->individual_courses = 1;
		else
			$module->individual_courses = 0;
		
		// the ardent package is responsible for the validation
		if ( $this->module->save() )
		{
			Flash::success('Modul erfolgreich erstellt!');
			return Redirect::back();
		}
		
		Flash::error($this->module->errors());
		return Redirect::back();
	}

	/**
	 * Display the specified resource.
	 * GET /modules/{id}
	 *
	 * @param  int  Module $module
	 * @return Response
	 */
	public function edit(Module $module)
	{
		$lists = array();
		$lists['departments'] 	= Department::orderBy('name','ASC')->lists('name','id');
		$lists['rotations'] 	= Rotation::orderBy('name','ASC')->lists('name','id');
		$lists['degrees'] 		= Degree::orderBy('name','ASC')->lists('name','id');
		$lists['sections'] 		= Section::orderBy('name','ASC')->lists('name','id');
		$lists['coursetypes'] 	= Coursetype::orderBy('name','ASC')->lists('name','id');
		// get courses
		$courses = $module->courses;
		
		return View::make('modules.editInformation', compact('module', 'courses', 'lists'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /modules/{id}
	 *
	 * @param  int  Module $module
	 * @return Response
	 */
	public function update(Module $module)
	{
		$module->fill(Input::all());
		if (Input::get('individual_courses') == "")
			$module->individual_courses = 0;
		else
			$module->individual_courses = 1;

		if ( $module->updateUniques() ) {
			Flash::success('Das Modul wurde aktualisiert.');
			return Redirect::back();
		}
		
		Flash::error($module->errors());
		return Redirect::back()->withInput();
	}
	
	/**
	 * Assigning a module to a degree course
	 * 
	 * @param Module $module
	 * @return Response
	 */
	public function attachDegreecourse(Module $module)
	{
		if($module->saveDegreecourse(Input::all())) {
			Flash::success('Das Modul wurde dem Studiengang zugeordnet.');
			return Redirect::back();
		}
		
		Flash::error('Die Kombination aus Modul-Studiengang-Semester existiert bereits.');
		return Redirect::back();
	}
	
	/**
	 * Detach a module from a degree course
	 * @param Module $module
	 */
	public function detachDegreecourse(Module $module, Specialistregulation $specialistregulation)
	{
		$module->specialistregulations()->detach($specialistregulation->id);

		Flash::success('Die Zuordnung wurde erfolgreich aufgehoben.');
		return Redirect::back();
	}
	
	/**
	 * update a degree course relationship
	 * 
	 * @param  Module $module [description]
	 * @return [type]         [description]
	 */
	public function updateDegreecourse(Module $module, Specialistregulation $specialistregulation)
	{
		$module->specialistregulations()
				->updateExistingPivot($specialistregulation->id, array(
					'semester' => Input::get('semester'), 
					'section' => Input::get('section'), 
					'updated_at' => new Datetime), false);

		Flash::success('Die Zuordnung wurde erfolgreich aktualisiert.');
		return Redirect::back();
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /modules/{id}
	 *
	 * @param  int  Module $module
	 * @return Response
	 */
	public function destroy(Module $module)
	{
		/*
		 * Check if there are courses assigned to this model
		 * if yes, the module can't be deleted
		 */
		if ($module->courses->count() > 0 || $module->mediumtermplannings->count() > 0) {
			Flash::error('Das Modul konnte nicht gelöscht werden, da dem Modul noch Lehrveranstaltungen bzw. mittelfristige Lehrplanungen zugeordnet sind.');
			return Redirect::back();
		}

		$module->delete();
		Flash::success('Modul erfolgreich gelöscht.');
		return Redirect::back();
	}

	/**
	 * show course which belong to the module
	 * @param  Module $module [description]
	 * @return [type]         [description]
	 */
	public function showCourses(Module $module)
	{
		$coursetypes = Coursetype::lists('id','name');
		return View::make('modules.courses', compact('module', 'coursetypes'));
	}

	/**
	 * show degree courses which the module is assigned to
	 * @param  Module $module [description]
	 * @return [type]         [description]
	 */
	public function showDegreecourses(Module $module)
	{
		$sections = Section::lists('name', 'id');
		$specialistregulations = Specialistregulation::getList();

		return View::make('modules.degreecourses', compact('module', 'degreecourses', 'sections', 'specialistregulations'));
	}

	/**
	 * show medium term plannings for a module
	 * @param  Module $module [description]
	 * @return [type]         [description]
	 */
	public function showMediumtermplannings(Module $module)
	{
		$mediumtermplannings = Mediumtermplanning::where('module_id',$module->id)->orderBy('turn_id','ASC')->get();
		$mediumtermplanningTurnIds = array();
		$mediumtermplanningTurns = array();
		foreach ($mediumtermplannings as $m) {
			array_push($mediumtermplanningTurnIds, $m->turn_id);
			$mediumtermplanningTurns = array_add($mediumtermplanningTurns, $m->id, $m->turn->name.' '.$m->turn->year);
		}
		if (sizeof($mediumtermplanningTurnIds) > 0)
			$turns = Turn::whereNotIn('id',$mediumtermplanningTurnIds)->orderBy('year','DESC')->orderBy('name','DESC')->get();
		else
			$turns = Turn::where('id','>',0)->orderBy('year','DESC')->orderBy('name','DESC')->get();
		$availableTurns = array();
		foreach ($turns as $turn) {
			$availableTurns = array_add($availableTurns,$turn->id, $turn->name.' '.$turn->year);
		}
		return View::make('modules.mediumtermplannings', compact('module', 'availableTurns', 'mediumtermplannings', 'mediumtermplanningTurns'));
	}
	
	// public function export()
	// {
	// 	$modules = Module::all();
	// 	$dgm = DB::table('degree_course_module')
	// 			->select('degree_course_id', 'module_id', 'semester', 'section')
	// 			->get();
	// 	$this->layout->content = View::make('modules.export', compact('modules','dgm'));
	// }

}