<h4>
	@if ($currentUser->hasRole('Admin') || $currentUser->can('edit_course'))
		{{ link_to_route('editCourseInformation_path', $planning->course_number.' '.$planning->course_title, $course->id) }}
	@else
		{{ $planning->course_number }} {{ $planning->course_title }} 
	@endif
	
	@if ($currentUser->hasRole('Admin') || $currentUser->can('edit_module'))
		({{ link_to_route('showModule_path', $course->module->short, $course->module_id) }}</a>)
	@else
		({{ $course->module->short }})
	@endif
	- {{ $turn->present() }}
</h4>

<h5>{{ $title }}</h5>