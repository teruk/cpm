<h4>
	@if ($currentUser->hasRole('Admin') || $currentUser->can('edit_course'))
		{{ link_to_route('showCourse_path', $planning->course_number.' '.$planning->course_title, $course->id) }}
	@else
		{{ $planning->course_number }} {{ $planning->course_title }} 
	@endif
	@if ($currentUser->hasRole('Admin') || $currentUser->can('edit_module'))
		(<a href="{{ route('modules.show', $course->module_id) }}">{{ $course->module->short }}</a>)
	@else
		({{ $course->module->short }})
	@endif
	- {{ $turn->present() }}
</h4>

<h5>{{ $title }}</h5>