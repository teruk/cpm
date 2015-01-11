<div class="col-md-3" style="border: 1px; border-style: rounded;">

	<ul class="list-unstyled">
		<li><b>Optionen:</b></li>
	</ul>
	<div class="btn-group-vertical">
		{{ link_to_route('editUserInformation_path', 'Informationen bearbeiten', [$user->id], ['class' => 'btn btn-default']) }}
		{{ link_to_route('editUserResearchgroups_path', 'Zugeordnete Arbeitsbereiche', [$user->id], ['class' => 'btn btn-default']) }}
		{{ link_to_route('editUserRoles_path', 'Zugeordnete Rollen', [$user->id], ['class' => 'btn btn-default']) }}
		{{ link_to_route('setUserPassword_path', 'Passwort zurücksetzen', [$user->id], ['class' => 'btn btn-default']) }}
		{{ link_to_route('setUserStatus_path', 'Status ändern', [$user->id], ['class' => 'btn btn-default']) }}
	</div>

	<ul class="list-unstyled">
		<li>{{ link_to_route('showUsers_path', 'Zurück zur Übersicht', null, ['class' => 'btn btn-sm btn-link']) }}</li>
	</ul>
</div>