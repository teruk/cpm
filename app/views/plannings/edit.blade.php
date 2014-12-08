@section('scripts')
	@include('layouts.partials.calendar-script', ['weekends' => 'false'])
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li><a href="{{ URL::to('plannings')}}">Semesterplanung</a></li>
	  <li><a href="{{ URL::route('plannings.indexTurn', $turn->id)}}">{{ $turn->name }} {{ $turn->year }}</a></li>
	  <li  class="active">{{$course->module->short}} {{ $course->module->name }}</li>
	</ol>
@stop

@section('main')
	<h4>Semesterplanung {{ $turn->name }} {{ $turn->year }}: 
		@if ($currentUser->hasRole('Admin') || $currentUser->can('edit_course'))
			<a href="{{ route('courses.show', $course->id) }}">{{ $planning->course_number }} {{ $planning->course_title }}</a>  
		@else
			{{ $planning->course_number }} {{ $planning->course_title }} 
		@endif
		@if ($currentUser->hasRole('Admin') || $currentUser->can('edit_module'))
			(<a href="{{ route('modules.show', $course->module_id) }}">{{ $course->module->short }}</a>)
		@else
			({{ $course->module->short }})
		@endif
	</h4>
		
	<ul class="nav nav-tabs" style="margin-bottom: 15px;">
		{{ (Session::get('plannings_edit_tabindex') == 0) ? '<li class="active">' : '<li>' }} <a href="#home" data-toggle="tab">Übersicht</a></li>
		{{ (Session::get('plannings_edit_tabindex') == 1) ? '<li class="active">' : '<li>' }} <a href="#lecturer" data-toggle="tab">Lehrende</a></li>
		{{ (Session::get('plannings_edit_tabindex') == 2) ? '<li class="active">' : '<li>' }} <a href="#rooms" data-toggle="tab">Räume</a></li>
		@if ($planning->course->module->individual_courses == 0)
			{{ (Session::get('plannings_edit_tabindex') == 3) ? '<li class="active">' : '<li>' }} <a href="#exam" data-toggle="tab">Modulabschluss</a></li>
		@endif
		{{ (Session::get('plannings_edit_tabindex') == 5) ? '<li class="active">' : '<li>' }} <a href="#planninglog" data-toggle="tab">Änderungsprotokoll</a></li>
	</ul>
	
	<div id="myTabContent" class="tab-content">
		<div class='{{ (Session::get('plannings_edit_tabindex') == 0) ? 'tab-pane fade active in' : 'tab-pane fade' }}' id="home">
			@include('plannings.partials.editPlanning')
		</div>
		
		<div class='{{ (Session::get('plannings_edit_tabindex') == 1) ? 'tab-pane fade active in' : 'tab-pane fade' }}' id="lecturer">
			@include('plannings.partials.editEmployees')
		</div>
		
		<div class='{{ (Session::get('plannings_edit_tabindex') == 2) ? 'tab-pane fade active in' : 'tab-pane fade' }}' id="rooms">
			@include('plannings.partials.editRooms')
		</div>

		<div class='{{ (Session::get('plannings_edit_tabindex') == 3) ? 'tab-pane fade active in' : 'tab-pane fade' }}' id="exam">
			@include('plannings.partials.editExam')
		</div>

		<div class='{{ (Session::get('plannings_edit_tabindex') == 5) ? 'tab-pane fade active in' : 'tab-pane fade' }}' id="planninglog">
			@include('plannings.partials.planninglog')
		</div>
	</div>

	@if ($currentUser->can('add_planning_room') || $currentUser->hasRole('Admin'))
		<p><strong>Zu beachtende Vorlesungen anderer Pflichtveranstaltungen dieses Semesters:</strong></p>
		@include('plannings.partials.conflictTable')
	@endif
@stop