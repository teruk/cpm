<div class="col-md-3" style="border: 1px; border-style: rounded;">

	<ul class="list-unstyled">
		<li><b>Optionen:</b></li>
	</ul>
	<div class="btn-group-vertical">
		{{ link_to_route('editCourseInformation_path', 'Informationen bearbeiten', [$course->id], ['class' => 'btn btn-default']) }}
		{{ link_to_route('showCourseHistory_path', 'Veranstaltungschronik', [$course->id], ['class' => 'btn btn-default']) }}
	</div>

	<ul class="list-unstyled">
		<li>{{ link_to_route('showCourses_path', 'Zurück zur Übersicht', null, ['class' => 'btn btn-sm btn-link']) }}</li>
	</ul>

</div>