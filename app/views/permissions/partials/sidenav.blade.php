<div class="col-md-3" style="border: 1px; border-style: rounded;">

	<ul class="list-unstyled">
		<li><b>Optionen:</b></li>
	</ul>
	<div class="btn-group-vertical btn-block">
		{{ link_to_route('editPermissionInformation_path', 'Informationen bearbeiten', [$permission->id], ['class' => 'btn btn-default']) }}
		{{ link_to_route('showPermissions_path', 'Zurück zur Übersicht', null, ['class' => 'btn btn-link']) }}
	</div>

	<ul class="list-unstyled">
		<li><b>Zugeordnete Rollen:</b></li>
		@foreach ($permission->roles as $role)
			@if ($currentUser->hasRole('Admin') OR $currentUser->can('edit_role'))
				<li>{{ link_to_route('showRole_path', $role->name, $role->id)}}</li>
			@else
				<li>{{ $role->name }}</li>
			@endif
		@endforeach
	</ul>
</div>