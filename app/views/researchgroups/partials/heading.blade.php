<h4>
	{{ $researchgroup->name }} 
	@if ($currentUser->hasRole('Admin') OR $currentUser->can('edit_department'))
		({{ link_to_route('editDepartmentInformation_path', $researchgroup->department->name, $researchgroup->department_id) }})
	@else
		{{ $researchgroup->department->name }}
	@endif
</h4>
<h5>{{ $title }}</h5>