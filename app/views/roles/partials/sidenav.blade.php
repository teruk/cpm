<div class="col-md-3" style="border: 1px; border-style: rounded;">

	<ul class="list-unstyled">
		<li><b>Optionen:</b></li>
	</ul>
	<div class="btn-group-vertical btn-block">
		{{ link_to_route('editRoleInformation_path', 'Informationen bearbeiten', [$role->id], ['class' => 'btn btn-default']) }}
		{{ link_to_route('showRolePermissions_path', 'Zugeordnete Berechtigungen', [$role->id], ['class' => 'btn btn-default']) }}
		{{ link_to_route('showRoleUsers_path', 'Rolleninhaber', [$role->id], ['class' => 'btn btn-default']) }}
		{{ link_to_route('showRoles_path', 'Zurück zur Übersicht', null, ['class' => 'btn btn-link']) }}
	</div>

</div>