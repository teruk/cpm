@include('courses.partials.breadcrumb', ['breadcrumbTitle' => 'Veranstaltungschronik'])

@section('main')

	<div class="row">
		@include('courses.partials.sidenav')

		<div class="col-md-9">
			@include('courses.partials.heading', ['title' => 'Veranstaltungschronik:'])

			<div class="table-responsive">
	           	<table class="table table-striped table-condensed" cellspacing="0">
	           		<thead>
	           			<tr>
	           				<th>Semester</th>
	           				<th>Nummer</th>
	           				<th>Titel</th>
	           				<th>Sprache</th>
	           				<th>Verantwortliche</th>
	           				<th>Raum</th>
	           			</tr>
	           		</thead>
	           		<tbody>
	           			@if (sizeof($history) > 0)
	           				@foreach ($history as $planning)
	           					<tr>
	           						<td>{{ $planning->turn->present() }}</td>
	           						<td>{{ $planning->course->course_number }}</td>
	           						<td>{{ $planning->course->name }}</td>
	           						<td>{{ Config::get('constants.language')[$planning->language] }}</td>
	           						<td>
	           							@foreach($planning->employees as $employee)
	           								@if ($currentUser->hasRole('Admin'))
	           									{{ link_to_route('showEmployee_path', $employee->present(), $employee->id) }}<br>
	           								@else
	           									{{ $employee->present() }} ({{ $employee->pivot->semester_periods_per_week }} SWS)<br>
	           								@endif
	           							@endforeach
	           						</td>
	           						<td>
	           							@foreach($planning->rooms as $room)
	           								{{ $room->name }} ({{ Config::get('constants.weekdays_short')[$room->pivot->weekday] }}, {{ substr($room->pivot->start_time,0,5) }}-{{ substr($room->pivot->end_time,0,5) }})<br>
	           							@endforeach
	           						</td>
	           					</tr>
	           				@endforeach
	           			@else
	           				<tr>
	           					<td colspan=6>Keine Aufzeichnungen vorhanden</td>
	           				</tr>
	           			@endif
	           		</tbody>
	           	</table>
	        </div>
		</div>
	</div>
@stop