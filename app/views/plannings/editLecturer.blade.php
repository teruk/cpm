@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li><a href="{{ URL::route('showTurnPlannings_path', $turn->id)}}">Semesterplanung</a></li>
	  <li><a href="{{ URL::route('showTurnPlannings_path', $turn->id)}}">{{ $turn->present() }}</a></li>
	  <li  class="active">{{$course->module->short}} {{ $course->module->name }}</li>
	  <li class="active">Lehrende bearbeiten</li>
	</ol>
@stop

@section('main')

	<div class="row">
		@include('plannings.partials.sidenav', ['showEmployees' => false, 'showRooms' => true, 'showInformation' => true])

		<div class="col-md-9">
			@include('plannings.partials.heading', ['title' => 'Lehrende verwalten:'])
			
			<p>[Infotext]</p>
			<div class="panel panel-default">
            	<div class="panel-body form-horizontal" style="margin-bottom: -20px">

            		<table class="table table-striped table-condensed">
	        			<thead>
	        				<tr>
								<th>Lehrende</th>
								<th>SWS</th>
								<th colspan=2>Optionen</th>
							</tr>
	        			</thead>
						<tbody>
							@if(sizeof($planning->employees) == 0)
	        					<tr>
	        						<td colspan=4>Momentan sind dieser Veranstaltung keine Lehrenden zugeordnet!</td>
	        					</tr>
	        				@else
								 @foreach($planning->employees as $ccte)
									<tr>
										{{ Form::model($planning, ['method' => 'PATCH', 'route' => ['updatePlanningLecturer_path', $turn->id, $planning->id]]) }}
	            						{{ Form::hidden('employee_id', $ccte->id) }}
										<td>{{ $ccte->title }} {{ $ccte->firstname }} {{ $ccte->name }} ({{ $ccte->researchgroup->short}})</td>
										<td>
											@if (Entrust::can('update_planning_employee') || Entrust::hasRole('Admin'))
												{{ Form::input('number', 'semester_periods_per_week', $ccte->pivot->semester_periods_per_week, array('min' => 0, 'max' => $course->semester_periods_per_week, 'step' => 0.5, 'class' => 'form-control input-sm'))}}
											@else
												{{ $ccte->pivot->semester_periods_per_week }}
											@endif
										</td>
										<td>
											@if (Entrust::can('update_planning_employee') || Entrust::hasRole('Admin'))
												{{ Form::button('<i class="glyphicon glyphicon-refresh"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Informationen aktualisieren')) }}
												{{ Form::close() }}
											@endif
										</td>
										<td>
											@if (Entrust::can('delete_planning_employee') || Entrust::hasRole('Admin'))
												{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('detachPlanningLecturer_path', $turn->id, $planning->id))) }}
		            							{{ Form::hidden('employee_id', $ccte->id) }}
		            							{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-danger', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Zuordnung löschen')) }}
		            							{{ Form::close() }}
		            						@endif
										</td>
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
				</div>
			</div>

			@if (Entrust::can('add_planning_employee') || Entrust::hasRole('Admin'))
				{{ Form::model($planning, ['method' => 'POST', 'route' => ['assignPlanningLecturer_path', $turn->id, $planning->id]]) }}
				<div class="panel panel-default">
	            	<div class="panel-body form-horizontal" style="margin-bottom: -20px">
	            		<table class="table table-striped table-condensed">
	            			<thead>
	            				<tr>
									<th>Neues Lehrpersonal zuordnen:</th>
									<th>SWS</th>
									<th colspan="2">Zuordnen</th>
								</tr>
	            			</thead>
							<tbody>
								<tr>
									<td>{{ Form::select('employee_id', $employees,'', array('class' => 'form-control input-sm')) }} </td>
									<td>{{ Form::input('number', 'semester_periods_per_week', 1, array('id' => 'semester_periods_per_week', 'min' => 0, 'max' => $course->semester_periods_per_week, 'step' => 0.5, 'class' => 'form-control input-sm'))}}</td>
									<td colspan="2">{{ Form::button('<i class="glyphicon glyphicon-arrow-right"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-success', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Person zuordnen')) }}</td>
								</tr>
							</tbody>
						</table>
            		</div>          	
            	</div>
            	{{ Form::close() }} 
			@endif

            @include('plannings.partials.relatedPlanningEmployees')
        </div>
    </div>
@stop