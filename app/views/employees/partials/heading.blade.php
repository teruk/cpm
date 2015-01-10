<h4>
	{{ $employee->present() }} 
	@if ($currentUser->hasRole('Admin') OR $currentUser->can('edit_researchgroup'))
		({{ link_to_route('showResearchgroup_path', $employee->researchgroup->short, $employee->researchgroup_id) }})
	@else
		({{ $employee->researchgroup->short }})
	@endif
</h4>
<h5>{{ $title }}</h5>