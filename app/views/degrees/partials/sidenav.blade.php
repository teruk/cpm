<div class="col-md-3" style="border: 1px; border-style: rounded;">

	<ul class="list-unstyled">
		<li><b>Optionen:</b></li>
	</ul>
	<div class="btn-group-vertical btn-block">
		{{ link_to_route('editDegreeInformation_path', 'Informationen bearbeiten', [$degree->id], ['class' => 'btn btn-default']) }}
		{{ link_to_route('showDegrees_path', 'Zurück zur Übersicht', null, ['class' => 'btn btn-link']) }}
	</div>

</div>