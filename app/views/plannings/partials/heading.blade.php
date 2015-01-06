<h4>
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
	- {{ $turn->present() }}
</h4>

<h5>{{ $title }}</h5>