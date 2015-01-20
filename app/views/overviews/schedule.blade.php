@section('scripts')
	@include('layouts.partials.calendar-script', ['weekends' => 'true'])
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li class="active">Übersichten</li>
	  <li class="active">Stundenpläne</li>
	  <li class="active">{{ $turn->present() }} </li>
	  <li class="active">{{ $specialistregulation->present() }}</li>
	  <li class="active">Fachsemester: {{ $semester }}</li>
	</ol>
@stop

@section('main')
	<h4>Stundenplan {{ $specialistregulation->present() }} {{ $semester }}. Fachsemester im {{ $turn->present() }}</h4>
	<div class="row" style="margin-bottom: 5px;">
		{{ Form::model($turn, ['method' => 'PATCH', 'route' => ['fetchSchedule_path']]) }}
		<div class="col-xs-2">
		{{ Form::select('turnId', $turns, $turn->id, array('id' => "turnId", 'class' => "form-control input-sm"))}}
		</div>
		<div class="col-xs-3">
			{{ Form::select('specialistregulationId', $specialistregulations, $specialistregulation->id, array('id' => "specialistregulationId", 'class' => "form-control input-sm"))}}
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
			    	@if ($specialistregulation->degreecourse->degree->name == "Master")
			    		{{ link_to_route('showSchedule_path', 'FS: 1', [$turn->id, $specialistregulation->id, 1], ['class' => 'btn btn-default']) }}
			    		{{ link_to_route('showSchedule_path', 'FS: 2', [$turn->id, $specialistregulation->id, 2], ['class' => 'btn btn-default']) }}
			    		{{ link_to_route('showSchedule_path', 'FS: 3', [$turn->id, $specialistregulation->id, 3], ['class' => 'btn btn-default']) }}
			    		{{ link_to_route('showSchedule_path', 'FS: 4', [$turn->id, $specialistregulation->id, 4], ['class' => 'btn btn-default']) }}
			    		{{ link_to_route('showSchedule_path', 'FS: Alle', [$turn->id, $specialistregulation->id, 0], ['class' => 'btn btn-default']) }}
					@else
						{{ link_to_route('showSchedule_path', 'FS: 1', [$turn->id, $specialistregulation->id, 1], ['class' => 'btn btn-default']) }}
			    		{{ link_to_route('showSchedule_path', 'FS: 2', [$turn->id, $specialistregulation->id, 2], ['class' => 'btn btn-default']) }}
			    		{{ link_to_route('showSchedule_path', 'FS: 3', [$turn->id, $specialistregulation->id, 3], ['class' => 'btn btn-default']) }}
			    		{{ link_to_route('showSchedule_path', 'FS: 4', [$turn->id, $specialistregulation->id, 4], ['class' => 'btn btn-default']) }}
			    		{{ link_to_route('showSchedule_path', 'FS: 5', [$turn->id, $specialistregulation->id, 5], ['class' => 'btn btn-default']) }}
			    		{{ link_to_route('showSchedule_path', 'FS: 6', [$turn->id, $specialistregulation->id, 6], ['class' => 'btn btn-default']) }}
			    		{{ link_to_route('showSchedule_path', 'FS: Alle', [$turn->id, $specialistregulation->id, 0], ['class' => 'btn btn-default']) }}
					@endif
			    </div>
			</div>
		</div>
	</div>
		<div id='calendar'></div>
@stop