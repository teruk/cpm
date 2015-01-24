<div class="col-md-3" style="border: 1px; border-style: rounded;">

	<ul class="list-unstyled">
		<li><b>Optionen:</b></li>
	</ul>
	<div class="btn-group-vertical btn-block">
		{{ link_to_route('editAppointeddayInformation_path', 'Informationen bearbeiten', [$appointedday->id], ['class' => 'btn btn-default']) }}
		{{ link_to_route('showAppointeddays_path', 'Zurück zur Übersicht', null, ['class' => 'btn btn-link']) }}
	</div>

	<ul class="list-unstyled">
		<li><b>Verfasst von:</b></li>
		<li>{{ $appointedday->user->name}}</li>
		<li><b>Erstellt am:</b></li>
		<li>{{ date('d.m.Y', strtotime($appointedday->created_at))}}</li>
		<li><b>Letzte Änderung am:</b></li>
		<li>{{ date('d.m.Y', strtotime($appointedday->updated_at))}}</li>
	</ul>

</div>