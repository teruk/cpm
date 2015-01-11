<div class="col-md-3" style="border: 1px; border-style: rounded;">

	<ul class="list-unstyled">
		<li><b>Optionen:</b></li>
	</ul>
	<div class="btn-group-vertical">
		{{ link_to_route('editTurnInformation_path', 'Informationen bearbeiten', [$turn->id], ['class' => 'btn btn-default']) }}
	</div>

	<ul class="list-unstyled">
		<li>{{ link_to_route('showTurns_path', 'Zurück zur Übersicht', null, ['class' => 'btn btn-sm btn-link']) }}</li>
	</ul>
</div>