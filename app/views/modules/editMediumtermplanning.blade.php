@extends('layouts.main')

@section('scripts')
	@include('layouts.partials.delete-confirm-js')
@stop

@include('modules.partials.breadcrumb', ['breadcrumbTitle' => 'Mittelfristige Lehrplannung '.$mediumtermplanning->turn->present()])

@section('main')
	
	<div class="row">
		@include('modules.partials.sidenav')

		<div class="col-md-9">
			@include('modules.partials.heading', ['title' => 'Mittelfristige Lehrplanung für das '.$mediumtermplanning->turn->present().' bearbeiten:'])

			<p>[Infotext bearbeiten]</p>

			<div class="panel panel-default">
            	<div class="panel-body">
	              	<table class="table table-striped table-condensed">
	              		<thead>
	              			<tr>
	              				<th>Verantwortliche Personen</th>
	              				<th>SWS</th>
	              				<th>Inaktiv</th>
	              				<th colspan=2 width="10%">Optionen</th>
	              			</tr>
	              		</thead>
	              		<tbody>	
	          				@if ($mediumtermplanning->employees->count() > 0)
	          					@foreach ($mediumtermplanning->employees as $employee)
	          						{{ Form::model($module, ['method' => 'PATCH', 'route' => ['updateEmployeeMediumtermplanning_path', $module->id, $mediumtermplanning->id]]) }}
	          						{{ Form::hidden('employee_id', $employee->id) }}
	          						<tr>
	          							<td>{{ $employee->firstname }} {{ $employee->name }}</td>
	          							<td>{{ Form::input('number','semester_periods_per_week', $employee->pivot->semester_periods_per_week, array('min' => 0, 'max' => $module->credits, 'step' => 0.5, 'id' => "semester_periods_per_week", 'class' => "form-control input-sm", 'required' => true)) }}</td>
	          							<td>{{ Form::checkbox('annulled', 1, $employee->pivot->annulled) }}</td>
	          							<td>
	          								@if ($currentUser->hasRole('Admin') OR $currentUser->can('edit_mediumtermplanning'))
	          									{{ Form::button('<i class="glyphicon glyphicon-refresh"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Informationen aktualisieren')) }}
	          								@endif
	          							</td>
	          						{{ Form::close() }}
	          							<td>
	          								@if ($currentUser->hasRole('Admin') OR $currentUser->can('edit_mediumtermplanning'))
		          								{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('detachEmployeeMediumtermplanning_path', $module->id, $mediumtermplanning->id))) }}
		          								{{ Form::hidden('employee_id', $employee->id) }}
		          								{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'button', 'class' => 'btn btn-xs btn-danger','data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Zuordnung löschen', 'data-message' => 'Wollen Sie die Mitarbeiterzuordnung wirklich löschen?')) }}
		          								{{ Form::close() }}
		          							@endif
	          							</td>
	          						</tr>
	          					@endforeach
	          				@else
	          					<tr><td colspan=5>Keine Mitarbeiter zugeordnet</td></tr>
	          				@endif
	          			</tbody>
	          			<tfoot>
	          				<tr>
	          					<th colspan="5">Verantwortliche Person zuordnen:</th>
	          				</tr>
	          				@if ($currentUser->hasRole('Admin') OR $currentUser->can('edit_mediumtermplanning'))
		          				{{ Form::model($module, ['method' => 'POST', 'route' => ['attachEmployeeMediumtermplanning_path', $module->id, $mediumtermplanning->id]]) }}
		  							<tr>
		  								<td>{{ Form::select('employee_id', $availableEmployees,'',array('id' => "employee_id", 'class' => "form-control input-sm")) }} </td>
		  								<td>{{ Form::input('number','semester_periods_per_week', 2, array('min' => 0, 'max' => $module->credits, 'step' => 0.5, 'id' => "semester_periods_per_week", 'class' => "form-control input-sm", 'required' => true)) }} </td>
		  								<td>{{ Form::checkbox('annulled', 1) }} </td>
		  								<td>{{ Form::hidden('tabindex', "mediumtermplanning") }}</td>
		  								<td>{{ Form::button('<i class="glyphicon glyphicon-arrow-right"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-success', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Verantwortliche Person zuordnen')) }}</td>
		  							</tr>
		  						{{ Form::close() }}
		  					@endif
	  					</tfoot>
	  				</table>
	  			</div>
	  		</div>
		</div>
	</div>

	<!-- delete confirmation modal dialog -->
  	@include('layouts.partials.delete_confirm')
@stop