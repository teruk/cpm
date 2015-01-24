<div class="col-md-3" style="border: 1px; border-style: rounded;">

	<ul class="list-unstyled">
		<li><b>Optionen:</b></li>
	</ul>
	<div class="btn-group-vertical btn-block">
		{{ link_to_route('editEmployeeInformation_path', 'Informationen bearbeiten', [$employee->id], ['class' => 'btn btn-default']) }}
		{{ link_to_route('showEmployeeCourseHistory_path', 'Betreute Veranstaltungen', [$employee->id], ['class' => 'btn btn-default']) }}
		{{ link_to_route('showEmployees_path', 'Zurück zur Übersicht', null, ['class' => 'btn btn-link']) }}
	</div>

</div>