@section('scripts')
	@include('layouts.partials.delete-confirm-js')
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
		<li><a href="{{ route('modules.index') }}">Modulmanagement</a></li>
		<li><a href="{{ route('modules.show', $module->id) }}">{{ $module->name }}</a></li>
		<li class="active">Mittelfristige Lehrplanung</li>
		<li class="active">{{ $mediumtermplanning->turn->name }} {{ $mediumtermplanning->turn->year }}</li>
	</ol>
@stop

@section('main')
	<h4>Mittelfristige Lehrplanung: <a href="{{ route('modules.show', $module->id) }}">{{ $module->name }}</a> ({{ $mediumtermplanning->turn->name }} {{ $mediumtermplanning->turn->year }})</h4>
  <div class="row">
  	<div class="col-sm-7">
  		<div class="panel panel-primary">
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
          				@if (sizeof($mediumtermplanning->employees) > 0)
          					@foreach ($mediumtermplanning->employees as $employee)
          						{{ Form::model($module, ['method' => 'PATCH', 'route' => ['modules.updateEmployee', $module->id, $mediumtermplanning->id]]) }}
          						{{ Form::hidden('employee_id', $employee->id) }}
          						{{ Form::hidden('tabindex', "mediumtermplanning") }}
          						<tr>
          							<td>{{ $employee->firstname }} {{ $employee->name }}</td>
          							<td>{{ Form::input('number','semester_periods_per_week', $employee->pivot->semester_periods_per_week, array('min' => 0, 'max' => $module->credits, 'step' => 0.5, 'id' => "semester_periods_per_week", 'class' => "form-control input-sm", 'required' => true)) }}</td>
          							<td>{{ Form::checkbox('annulled', 1, $employee->pivot->annulled) }}</td>
          							<td>{{ Form::button('<i class="glyphicon glyphicon-refresh"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Informationen aktualisieren')) }}</td>
          						{{ Form::close() }}
          							<td>
          								{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('modules.destroyEmployee', $module->id, $mediumtermplanning->id))) }}
          								{{ Form::hidden('employee_id', $employee->id) }}
          								{{ Form::hidden('tabindex', "mediumtermplanning") }}
          								{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'button', 'class' => 'btn btn-xs btn-danger','data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Zuordnung löschen', 'data-message' => 'Wollen Sie die Mitarbeiterzuordnung wirklich löschen?')) }}
          								{{ Form::close() }}
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
          				{{ Form::model($module, ['method' => 'POST', 'route' => ['modules.addEmployee', $module->id, $mediumtermplanning->id]]) }}
  							<tr>
  								<td>{{ Form::select('employee_id', $available_employees,'',array('id' => "employee_id", 'class' => "form-control input-sm")) }} </td>
  								<td>{{ Form::input('number','semester_periods_per_week', 2, array('min' => 0, 'max' => $module->credits, 'step' => 0.5, 'id' => "semester_periods_per_week", 'class' => "form-control input-sm", 'required' => true)) }} </td>
  								<td>{{ Form::checkbox('annulled', 1) }} </td>
  								<td>{{ Form::hidden('tabindex', "mediumtermplanning") }}</td>
  								<td>{{ Form::button('<i class="glyphicon glyphicon-arrow-right"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-success', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Verantwortliche Person zuordnen')) }}</td>
  							</tr>
  						{{ Form::close() }}
  					</tfoot>
  				</table>
  			</div>
  		</div>
  	</div>
  </div>

  <!-- delete confirmation modal dialog -->
  @include('layouts.partials.delete_confirm')
@stop