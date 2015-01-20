<div class="col-md-3" style="border: 1px; border-style: rounded;">
	<!-- <div class="panel panel-default">
    	<div class="panel-body"> -->
	
			<!-- <ul class="list-unstyled">
				<li><b>Planungsoptionen:</b></li>
				<li>{{ link_to_route('editPlanningInformation_path', 'Informationen bearbeiten', [$turn->id, $planning->id], ['class' => 'btn btn-sm btn-link']) }}</li>
				<li>{{ link_to_route('editPlanningLecturer_path', 'Lehrende verwalten', [$turn->id, $planning->id], ['class' => 'btn btn-sm btn-link']) }}</li>
				<li>{{ link_to_route('editPlanningRoom_path', 'Räume verwalten', [$turn->id, $planning->id], ['class' => 'btn btn-sm btn-link']) }}</li>
				<li>{{ link_to_route('editPlanningExam_path', 'Modulabschluss bearbeiten', [$turn->id, $planning->id], ['class' => 'btn btn-sm btn-link']) }}</li>
				<li>{{ link_to_route('showPlanningProtocol_path', 'Änderungsprotokoll', [$turn->id, $planning->id], ['class' => 'btn btn-sm btn-link']) }}</li>
			</ul> -->

			<div class="btn-group-vertical">
				{{ link_to_route('editPlanningInformation_path', 'Informationen bearbeiten', [$turn->id, $planning->id], ['class' => 'btn btn-default']) }}
				{{ link_to_route('editPlanningLecturer_path', 'Lehrende verwalten', [$turn->id, $planning->id], ['class' => 'btn btn-default']) }}
				{{ link_to_route('editPlanningRoom_path', 'Räume und Zeiten verwalten', [$turn->id, $planning->id], ['class' => 'btn btn-default']) }}
				{{ link_to_route('editPlanningExam_path', 'Modulabschluss bearbeiten', [$turn->id, $planning->id], ['class' => 'btn btn-default']) }}
				{{ link_to_route('showPlanningProtocol_path', 'Änderungsprotokoll', [$turn->id, $planning->id], ['class' => 'btn btn-default']) }}
			</div>
			<ul class="list-unstyled">
				<li>{{ link_to_route('showTurnPlannings_path', 'Zurück zur Übersicht', [$turn->id], ['class' => 'btn btn-sm btn-link']) }}</li>
			</ul>

			<ul class="list-unstyled">
				<li><b>Letzte Änderung:</b></li>
				<li>{{ date('d.m.Y', strtotime($planning->updated_at))}}</li>
			</ul>

			@if ($showInformation)
				<ul class="list-unstyled">
					<li><b>Informationen:</b></li>
					<li>{{ $planning->course_number }} {{ $course->module->short }}</li>
					<li>{{ $course->coursetype->name }}</li>
					<li>Gruppe: {{ $planning->group_number }}</li>
				</ul>
			@endif

			@if ($showEmployees)
				<ul class="list-unstyled">
					<li><b>Zugeordnete Lehrende:</b></li>
					@foreach ($planning->employees as $employee)
						<li>{{ $employee->present() }}</li>
						<li>({{ $employee->pivot->semester_periods_per_week }} SWS)</li>
					@endforeach
				</ul>
			@endif

			@if ($showRooms)
				<ul class="list-unstyled">
					<li><b>Zugeordnete Räume:</b></li>
					@foreach ($planning->rooms as $room)
						<li>{{ $room->present() }}</li>
						<li>{{ Config::get('constants.weekdays_short')[$room->pivot->weekday] }}. {{ substr($room->pivot->start_time,0,5) }} - {{ substr($room->pivot->end_time,0,5) }} Uhr</li>
					@endforeach
				</ul>
			@endif

		<!-- </div>
	</div> -->
</div>