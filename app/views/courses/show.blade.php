@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li><a href="{{ URL::to('courses')}}">Lehrveranstaltungsmanagement</a></li>
	  <li class="active">{{ $course->name }}</li>
	</ol>
@stop

@section('main')
	<h3>{{ $course->course_number }} {{ $course->coursetype->name }} {{ $course->name }} (<a href="{{ route('modules.show', $course->module_id) }}">{{ $course->module->short }}</a>) </h3>
	
	<ul class="nav nav-tabs" style="margin-bottom: 15px;">
		@if ( $tabindex == 0 )
			<li class="active">
		@else
			<li>
		@endif
			<a href="#home" data-toggle="tab">Informationen</a></a>
			
		@if ( $tabindex == 1 )
			<li class="active">
		@else
			<li>
		@endif
			<a href="#history" data-toggle="tab">Veranstaltungschronik</a></li>

	</ul>
	
	<div id="myTabContent" class="tab-content">
		@if ( $tabindex == 0 )
			<div class="tab-pane fade active in" id="home">
		@else
			<div class="tab-pane fade" id="home">
		@endif
		
			<div class="row">
				<div class="col-sm-7">
				<div class="panel panel-primary">
			        <div class="panel-body">
						{{ Form::model($course, ['method' => 'PATCH', 'route' => ['courses.update', $course->id]]) }}
						<table class="table table-striped table-condensed">
							<tbody>
								<tr>
									<td>{{ Form::label('name', 'Name*:') }}</td>
									<td align="right">{{ Form::input('text', 'name', $course->name, array('id' => "name", 'min' => 3, 'required' => true, 'class' => "form-control input-sm")) }}</td>	
								</tr>	
								<tr>
									<td>{{ Form::label('name_eng', 'EngTitel*:') }}</td>
									<td align="right">{{ Form::input('text', 'name_eng', $course->name_eng, array('id' => "name_eng", 'min' => 3, 'required' => true, 'class' => "form-control input-sm")) }}</td>
								</tr>
								<tr>
									<td>{{ Form::label('course_number', 'LV-Nr.*:') }}</td>
									<td align="right">{{ Form::input('text', 'course_number', $course->course_number, array('id' => "course_number", 'min' => 3, 'required' => true, 'class' => "form-control input-sm")) }}</td>
								</tr>
								<tr>
									<td>{{ Form::label('coursetype_id', 'LV-Typ*:') }}</td>
									<td align="right">{{ Form::select('coursetype_id', $listofcoursetypes, $course->coursetype_id, array('id' => "coursetype_id", 'class' => "form-control input-sm")) }}</td>
								</tr>
								<tr>
									<td>{{ Form::label('participants', 'Teilnehmer*:') }}</td>
									<td align="right">{{ Form::input('number', 'participants', $course->participants, array('min' => 1, 'id' => "participants", 'class' => "form-control input-sm", 'required' => true)) }}</td>
								</tr>
								<tr>
									<td>{{ Form::label('semester_periods_per_week', 'SWS*:') }}</td>
									<td align="right">{{ Form::input('number', 'semester_periods_per_week', $course->semester_periods_per_week, array('min' => 1, 'step' => 0.5, 'id' => "semester_periods_per_week", 'class' => "form-control input-sm", 'required' => true)) }}</td>
								</tr>
								<tr>
									<td>{{ Form::label('language', 'Sprache*:') }}</td>
									<td align="right">{{ Form::select('language', Config::get('constants.language'), $course->language, array('id' => "language", 'class' => "form-control input-sm")) }}</td>
								</tr>
								<tr>
									<td>{{ Form::label('module_id', 'Modul:') }}</td>
									<td align="right">{{ Form::select('module_id', $listofmodules, $course->module_id, array('id' => "module_id", 'class' => "form-control input-sm")) }}</td>
								</tr>					 
								<tr>
									<td >* erforderlich</td>
									<td align="right">{{ Form::button('<i class="glyphicon glyphicon-refresh"></i> Aktualisieren', array('type' => 'submit', 'class' => 'btn btn-sm btn-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Informationen aktualisieren')) }}</td>
								</tr>
							</tbody>
						</table>
						{{ Form::close() }}
					</div>
				</div>
			</div>
			</div>
		</div>
		
		@if ( $tabindex == 1 )
			<div class="tab-pane fade active in" id="history">
		@else
			<div class="tab-pane fade" id="history">
		@endif
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-primary">
			            <div class="panel-body">
							<div  class="table-responsive">
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
					           						<td>{{ $planning->turn->name }} {{ $planning->turn->year }}</td>
					           						<td>{{ $planning->course->course_number }}</td>
					           						<td>{{ $planning->course->name }}</td>
					           						<td>{{ Config::get('constants.language')[$planning->language] }}</td>
					           						<td>
					           							@foreach($planning->employees as $employee)
					           								{{ $employee->firstname }} {{ $employee->name }} ({{ $employee->pivot->semester_periods_per_week }} SWS)<br>
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
				</div>
			</div>
		</div>
	</div>
@stop