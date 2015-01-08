@section('scripts')
	@include('layouts.partials.datatables-script')
	<script type="text/javascript" class="init">

		$(document).ready(function() {
			$('#employee_table').dataTable({
                "displayLength": 25,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Alle"]],
				"pagingType": "full"
			});

			$('div.dataTables_filter input').focus()
		} );
	</script>

	@include('layouts.partials.delete-confirm-js')
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li class="active">Mitarbeitermanagement</li>
	</ol>
@stop

@section('main')
	<!-- <h2>Mitarbeitermanagement
		<button class="btn btn-success btn-xs" data-toggle="modal" data-target="#myModal">
	  		<span class="glyphicon glyphicon-plus"></span>
		</button>
	</h2> -->

	@if (Entrust::hasRole('Admin') || Entrust::can('add_employee'))
		<div class="row">
			<div class="col-sm-12" style="margin-bottom: 5px;">
				<div class="btn-group">
				    <a href="#" class="btn btn-success btn-xs" data-toggle="modal" data-target="#myModal"><i class="glyphicon glyphicon-plus"></i> Mitarbeiter hinzufügen</a>
				</div>
				<div class="btn-group" align="right">
					<button type="button" class="btn btn-link btn-sm" data-container="body" data-toggle="popover" data-placement="bottom" data-content="Grün hinterlegte Mitarbeiter sind aktuell noch am Fachbereich. Bei gelb-hinterlegten Mitarbeiter wurde das Datum des Vertragsende bereits überschritten. Ehemalige Mitarbeiter sind grau hinterlegt." data-original-title="" title="" aria-describedby="popover55776">
						<span class="glyphicon glyphicon-question-sign"></span>
					</button>
				</div>
			</div>
		</div>
	@endif
	
	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">
			<div class="table-responsive">
		        <table class="table table-condensed table-hover" id="employee_table" cellspacing="0">
		        	<thead>
		                <tr>
		                	<th>Name</th>
		                  	<th>Arbeitsbereich</th>
		                   	<th>Lehrdeputat</th>
		                  	<th>Angestellt seit</th>
		                  	<th>Angestellt bis</th>
		                  	<th>Ehemalig</th>
		                  	<th>Optionen</th>
		                </tr>
		          	</thead>
		          	<tbody>
						@foreach( $employees as $employee )
							@if ($employee->inactive == 0)
								@if (date('d.m.Y', strtotime($employee->employed_till)) < date('d.m.Y'))
									<tr class="warning">
								@else
									<tr class="success">
								@endif
							@else
								<tr>
							@endif
								<td>{{ link_to_route('showEmployee_path', $employee->present(), $employee->id) }}</td>
								<td>
									@if (Entrust::hasRole('Admin') || Entrust::can('edit_researchgroup'))
										<a href="{{ route('researchgroups.show', $employee->researchgroup_id) }}">{{ $employee->researchgroup->short }}</a>
									@else
										{{ $employee->researchgroup->short }}
									@endif
								</td>
								<td>{{ $employee->teaching_load }} SWS</td>
								<td>{{ date('d.m.Y', strtotime($employee->employed_since)) }}</td>
								<td>{{ date('d.m.Y', strtotime($employee->employed_till)) }}</td>
								<td>
									@if ($employee->inactive == 1)
										ja
									@else
										nein
									@endif
								</td>
								<td>
									{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('deleteEmployee_path', $employee->id))) }}
										@if (Entrust::hasRole('Admin') || Entrust::can('edit_employee'))
										{{ HTML::decode(link_to_route('showEmployee_path', '<i class="glyphicon glyphicon-edit"></i>', array($employee->id), array('class' => 'btn btn-xs btn-warning'))) }}
										@endif
										@if (Entrust::hasRole('Admin') || Entrust::can('delete_employee'))
											{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'button', 'class' => 'btn btn-xs btn-danger', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Mitarbeiter löschen', 'data-message' => 'Wollen Sie den Mitarbeiter wirklich löschen?')) }}
										@endif
										{{ Form::close() }}
		    					</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- add form modal dialog -->
	@include('employees.partials.add-form')

	<!-- delete confirmation modal dialog -->
	@include('layouts.partials.delete_confirm')
@stop