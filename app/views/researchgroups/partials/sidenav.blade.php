<div class="col-md-3" style="border: 1px; border-style: rounded;">

	<ul class="list-unstyled">
		<li><b>Optionen:</b></li>
	</ul>
	<div class="btn-group-vertical btn-block">
		{{ link_to_route('editResearchgroupInformation_path', 'Informationen bearbeiten', [$researchgroup->id], ['class' => 'btn btn-default']) }}
		{{ link_to_route('showResearchgroupEmployees_path', 'Zugeordnetes Personal', [$researchgroup->id], ['class' => 'btn btn-default']) }}
		{{ link_to_route('showResearchgroupCourses_path', 'Betreute Veranstaltungen', [$researchgroup->id], ['class' => 'btn btn-default']) }}
		{{ link_to_route('showResearchgroups_path', 'Zurück zur Übersicht', null, ['class' => 'btn btn-link']) }}
	</div>

</div>