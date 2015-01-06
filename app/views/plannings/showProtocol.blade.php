@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li><a href="{{ URL::route('showTurnPlannings_path', $turn->id)}}">Semesterplanung</a></li>
	  <li><a href="{{ URL::route('showTurnPlannings_path', $turn->id)}}">{{ $turn->present() }}</a></li>
	  <li  class="active">{{$course->module->short}} {{ $course->module->name }}</li>
	  <li class="active">Änderungsprotokol</li>
	</ol>
@stop

@section('main')
	

	<div class="row">
		@include('plannings.partials.sidenav', ['showEmployees' => true, 'showRooms' => true, 'showInformation' => true])

		<div class="col-md-9">
			@include('plannings.partials.heading', ['title' => 'Änderungsprotokoll'])
			
			<p>Die an der Planung vorgenommenen Änderungen können im folgenden Protokoll nachvollzogen werden.</p>

			<!-- <div class="panel panel-default">
            	<div class="panel-body"> -->
            		
	            	<table class="table table-striped table-condensed">
	            		<thead>
	            			<tr>
	            				<th>Datum / Kategorie</th>
	            				<th>Benutzer</th>
	            				<th>Änderung</th>
	            			</tr>
	            		</thead>
	            		<tbody>
	            			@foreach($planninglog as $pl)
	            				@if ($pl->action_type == 0)
	                                <tr class='success'>
	                            @endif
	                            @if ($pl->action_type == 1)
	                                <tr class='info'>
	                            @endif
	                            @if ($pl->action_type == 2)
	                                <tr class='danger'>
	                            @endif
	            					<td>{{ date('d.m.Y - H:i', strtotime($pl->created_at))  }} {{ Config::get('constants.planninglog_category')[$pl->category] }}</td>
	            					<td>{{ $pl->username }}</td>
	            					<td>{{ $pl->action }}</td>
	            				</tr>
			            	@endforeach
	            		</tbody>
	            	</table>
            	<!-- </div>
            </div> -->
        </div>
    </div>
@stop