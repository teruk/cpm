@section('scripts')
	@include('layouts.partials.calendar-script', ['weekends' => 'true'])
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li class="active">Übersichten</li>
	  <li class="active">Stundenpläne</li>
	  <li class="active">{{ $turn->name }}  {{ $turn->year }} </li>
	  <li class="active">{{ $listofdegreecourses[$degreecourse->id] }}</li>
	  <li class="active">Fachsemester: {{ $semester }}</li>
	</ol>
@stop

@section('main')
	<h4>Stundenplan {{ $listofdegreecourses[$degreecourse->id] }} {{ $semester }}. Fachsemester im {{ $turn->name }}  {{ $turn->year }}</h4>
	<div class="row" style="margin-bottom: 5px;">
		{{ Form::model($turn, ['method' => 'PATCH', 'route' => ['overview.grab_schedule']]) }}
		<div class="col-xs-2">
		{{ Form::select('turn_id', $listofturns, $turn->id, array('id' => "turn_id", 'class' => "form-control input-sm"))}}
		</div>
		<div class="col-xs-3">
			{{ Form::select('degreecourse_id', $listofdegreecourses, $degreecourse->id, array('id' => "degreecourse_id", 'class' => "form-control input-sm"))}}
		</div>
		<div class="col-xs-1">
			{{ Form::button('<i class="glyphicon glyphicon-refresh"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-primary')) }}
			{{ Form::hidden('semester', $semester)}}
		</div>
		{{ Form::close() }}
	</div>

	<div class="row" style="margin-bottom: 5px;">
		<div class="col-sm-12">
			<div class="btn-toolbar">
			    <div class="btn-group  btn-group-justified">
			    	@if ($degreecourse->degree->name == "Master")
			    		{{ link_to_route('overview.specific_schedule', 'FS: 1', [$turn->id, $degreecourse->id, 1], ['class' => 'btn btn-default']) }}
			    		{{ link_to_route('overview.specific_schedule', 'FS: 2', [$turn->id, $degreecourse->id, 2], ['class' => 'btn btn-default']) }}
			    		{{ link_to_route('overview.specific_schedule', 'FS: 3', [$turn->id, $degreecourse->id, 3], ['class' => 'btn btn-default']) }}
			    		{{ link_to_route('overview.specific_schedule', 'FS: 4', [$turn->id, $degreecourse->id, 4], ['class' => 'btn btn-default']) }}
			    		{{ link_to_route('overview.specific_schedule', 'FS: Alle', [$turn->id, $degreecourse->id, 0], ['class' => 'btn btn-default']) }}
					@else
						{{ link_to_route('overview.specific_schedule', 'FS: 1', [$turn->id, $degreecourse->id, 1], ['class' => 'btn btn-default']) }}
			    		{{ link_to_route('overview.specific_schedule', 'FS: 2', [$turn->id, $degreecourse->id, 2], ['class' => 'btn btn-default']) }}
			    		{{ link_to_route('overview.specific_schedule', 'FS: 3', [$turn->id, $degreecourse->id, 3], ['class' => 'btn btn-default']) }}
			    		{{ link_to_route('overview.specific_schedule', 'FS: 4', [$turn->id, $degreecourse->id, 4], ['class' => 'btn btn-default']) }}
			    		{{ link_to_route('overview.specific_schedule', 'FS: 5', [$turn->id, $degreecourse->id, 5], ['class' => 'btn btn-default']) }}
			    		{{ link_to_route('overview.specific_schedule', 'FS: 6', [$turn->id, $degreecourse->id, 6], ['class' => 'btn btn-default']) }}
			    		{{ link_to_route('overview.specific_schedule', 'FS: Alle', [$turn->id, $degreecourse->id, 0], ['class' => 'btn btn-default']) }}
					@endif
			    </div>
			</div>
		</div>
	</div>
		<div id='calendar'></div>
@stop