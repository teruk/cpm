@extends('layouts.main')

@include('employees.partials.breadcrumb', ['breadcrumbTitle' => 'Betreute Veranstaltungen'])

@section('main')
	
	<div class="row">
		@include('employees.partials.sidenav')

		<div class="col-md-9">
			@include('employees.partials.heading', ['title' => 'Betreute Veranstaltungen:'])

			<p>Übersicht der betreuten Veranstaltungen durch den/die Mitarbeiter/in.</p>
			<div class="panel panel-default">
			    <div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped" cellspacing="0">
						    <thead>
								<tr>
								    <th>Semester</th>
								    <th>Veranstaltung</th>
								    <th>Verantwortliche</th>
								    <th>Raum - Uhrzeit</th>
							 	</tr>
						   	</thead>
						    <tbody>
								@foreach ($plannings as $p)	
									<tr>
										<td>{{ $p->turn->name }} {{ $p->turn->year }}</td>
										<td>{{ $p->course_number }} {{ $p->course_title }}</td>
										<td>
											@foreach ($p->employees as $e)
												{{ $e->firstname }} {{ $e->name }} ({{ $e->pivot->semester_periods_per_week }} SWS)<br>
											@endforeach
										</td>
										<td>
											@foreach ($p->rooms as $r)
												{{ $r->name }} ({{ $r->location }}) - {{ Config::get('constants.weekdays_short')[$r->pivot->weekday]}}, {{ substr($r->pivot->start_time,0,5) }} - {{ substr($r->pivot->end_time,0,5) }} Uhr<br>
											@endforeach
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop