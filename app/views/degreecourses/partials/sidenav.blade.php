<div class="col-md-3" style="border: 1px; border-style: rounded;">

	<ul class="list-unstyled">
		<li><b>Optionen:</b></li>
	</ul>
	<div class="btn-group-vertical btn-block">
		{{ link_to_route('editDegreecourseInformation_path', 'Informationen bearbeiten', [$degreecourse->id], ['class' => 'btn btn-default']) }}
		{{ link_to_route('editDegreecourseSpecialistregulations_path', 'FSB-Versionen verwalten', [$degreecourse->id], ['class' => 'btn btn-default']) }}
		{{ link_to_route('showDegreecourseModules_path', 'Zugeordnete Module', [$degreecourse->id], ['class' => 'btn btn-default']) }}
		{{ link_to_route('showDegreecourses_path', 'Zurück zur Übersicht', null, ['class' => 'btn btn-link']) }}
	</div>
</div>