<?php


use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
class ModulesController extends \BaseController {

	protected $module;

	public function __construct(Module $module)
	{
		$this->module = $module;
	}
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
		$this->module->fill(Input::all());
		if (Input::get('individual_courses') == "")
			$this->module->individual_courses = 0;
		else
			$this->module->individual_courses = 1;
		
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
		$lists['degreecourses'] = Degreecourse::getList();
		// get courses
// 		$courses = DB::table('courses')->where('module_id','=',$module->id)->get();
		$courses = $module->courses;

		$mtp = Mediumtermplanning::where('module_id',$module->id)->orderBy('turn_id','ASC')->get();
		$mtp_turn_ids = array();
		$mtp_turns = array();
		foreach ($mtp as $m) {
			array_push($mtp_turn_ids, $m->turn_id);
			$mtp_turns = array_add($mtp_turns, $m->id, $m->turn->name.' '.$m->turn->year);
		}
		if (sizeof($mtp_turn_ids) > 0)
			$turns = Turn::whereNotIn('id',$mtp_turn_ids)->orderBy('year','DESC')->orderBy('name','DESC')->get();
		else
			$turns = Turn::where('id','>',0)->orderBy('year','DESC')->orderBy('name','DESC')->get();
		$available_turns = array();
		foreach ($turns as $t) {
			$available_turns = array_add($available_turns,$t->id, $t->name.' '.$t->year);
		}
		
		return View::make('modules.editInformation', compact('module', 'courses', 'lists', 'tabindex','mtp','available_turns','mtp_turns'));
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

		if ( $module->updateUniques() )
		{
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
		if($module->saveDegreeCourse($input = Input::all()))
		{
			Flash::success('Das Modul wurde dem Studiengang zugeordnet.');
			return Redirect::back()->with('tabindex',$input['tabindex']);
		}
		
		Flash::error('Die Kombination aus Modul-Studiengang-Semester existiert bereits.');
		return Redirect::back()->with('tabindex',$input['tabindex']);
	}
	
	/**
	 * Detach a module from a degree course
	 * @param Module $module
	 */
	public function detachDegreecourse(Module $module)
	{
		$module->degreecourses()->detach(Input::get('degree_course_id'));

		Flash::success('Die Zuordnung wurde erfolgreich aufgehoben.');
		return Redirect::back()->with('tabindex',Input::get('tabindex'));
	}
	
	/**
	 * update a degree course relationship
	 * 
	 * @param  Module $module [description]
	 * @return [type]         [description]
	 */
	public function updateDegreecourse(Module $module)
	{
		$module->degreecourses()
				->updateExistingPivot(Input::get('degreecourse_id'), array(
					'semester' => Input::get('semester'), 
					'section' => Input::get('section'), 
					'updated_at' => new Datetime), false);

		Flash::success('Die Zuordnung wurde erfolgreich aktualisiert.');
		return Redirect::back()->with('tabindex',Input::get('tabindex'));
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
		if (sizeof($module->courses()) > 0)
		{
			Flash::error('Das Modul konnte nicht gelöscht werden, da dem Modul noch Lehrveranstaltungen zugeordnet sind.');
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
		$degreecourses = Degreecourse::getList();
		$sections = Section::lists('id','name');

		return View::make('modules.degreecourses', compact('module', 'degreecourses', 'sections'));
	}

	public function showMediumtermplannings(Module $module)
	{
		$mtp = Mediumtermplanning::where('module_id',$module->id)->orderBy('turn_id','ASC')->get();
		$mtp_turn_ids = array();
		$mtp_turns = array();
		foreach ($mtp as $m) {
			array_push($mtp_turn_ids, $m->turn_id);
			$mtp_turns = array_add($mtp_turns, $m->id, $m->turn->name.' '.$m->turn->year);
		}
		if (sizeof($mtp_turn_ids) > 0)
			$turns = Turn::whereNotIn('id',$mtp_turn_ids)->orderBy('year','DESC')->orderBy('name','DESC')->get();
		else
			$turns = Turn::where('id','>',0)->orderBy('year','DESC')->orderBy('name','DESC')->get();
		$available_turns = array();
		foreach ($turns as $t) {
			$available_turns = array_add($available_turns,$t->id, $t->name.' '.$t->year);
		}
		return View::make('modules.mediumtermplannings', compact('module', 'available_turns', 'mtp', 'mtp_turns'));
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