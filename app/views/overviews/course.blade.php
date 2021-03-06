@section('breadcrumbs')
	<ol class="breadcrumb">
		<li class="active">Übersichten</li>
		<li>{{ link_to_route('showOverviewCourses_path', 'Lehrveranstaltungen') }}</li>
		<li class="active">{{ $course->course_number }} ({{ $course->name }})</li>
	</ol>
@stop

@section('main')
	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">

			<table class="table table-striped table-condensed">
				<thead>
					<tr>
	        			<th colspan="7">Lehrveranstaltungsinformationen:</th>
	        		</tr>
					<tr>
		                <th>LV-Nr.</th>
		                <th>Modul</th>
		                <th>Titel / engl. Titel</th>
		                <th>Typ</th>
		                <th>Teilnehmer</th>
		                <th>SWS</th>
		                <th>Sprache</th>
	                </tr>
	          	</thead>
	          	<tbody>
						<tr>
							<td>{{ $course->course_number }}</td>
							<td>{{ link_to_route('showOverviewSelectedModule_path', $course->module->short, $course->module_id) }}</td>
							<td>{{ $course->name }}<br>{{ $course->name_eng }}</td>
							<td>{{ $course->coursetype->name }}</td>
							<td>{{ $course->participants }}</td>
							<td>{{ $course->semester_periods_per_week }}</td>
							<td>{{ Config::get('constants.language')[$course->language] }}</td>
						</tr>
				</tbody>
			</table>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">
			<div class="table-responsive">
		        <table class="table table-striped table-condensed" cellspacing="0">
		        	<thead>
					<tr>
	        			<th colspan="6">Durchführung der Lehrveranstaltung:</th>
	        		</tr>
					<tr>
		                <th>Semester</th>
		                <th>LV-Nr.</th>
		                <th>Lehrveranstaltung</th>
		                <th>Gruppe</th>
		                <th>Sprache</th>
		                <th>Veranstalter</th>
		                <th>Raum</th>
	                </tr>
	          	</thead>
	          	<tbody>
	          		@foreach ($course->plannings as $planning)
	          			<tr>
	          				<td>{{ $planning->turn->name}} {{ $planning->turn->year}}</td>
	          				<td>{{ $planning->course_number }}</td>
	          				<td>{{ $planning->course_title }}<br>{{ $planning->course_title_eng }}</td>
	          				<td>{{ $planning->group_number }}</td>
	          				<td>{{ Config::get('constants.language')[$planning->language] }}</td>
	          				<td>
	          					@foreach ($planning->employees as $employee)
	          						{{ link_to_route('showOverviewSelectedEmployee_path', $employee->present().' ('.$employee->pivot->semester_periods_per_week.')', $employee->id) }}
	          					@endforeach
	          				</td>
	          				<td>
	          					@foreach ($planning->rooms as $room)
	          						{{ $room->name }} ({{ Config::get('constants.weekdays_short')[$room->pivot->weekday] }}, {{ substr($room->pivot->start_time,0,5) }}-{{ substr($room->pivot->end_time,0,5) }} Uhr)<br>
	          					@endforeach
	          				</td>
	          			</tr>
	          		@endforeach
	          	</tbody>
				</table>
			</div>
		</div>
	</div>
@stop