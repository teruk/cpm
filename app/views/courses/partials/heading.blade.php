<h4>
	{{ $course->course_number }} {{ $course->coursetype->name }} {{ $course->name }} ({{ link_to_route('editModuleInformation_path', $course->module->short, $course->module_id) }})
</h4>
<h5>{{ $title }}</h5>