@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li><a href="{{ URL::to('researchgroups')}}">Arbeitsbereichsmanagement</a></li>
	  <li class="active">{{ $researchgroup->name }}</li>
	</ol>
@stop

@section('main')
	<h3>{{ $researchgroup->name }} (<a href="{{ route('departments.show', $researchgroup->department_id) }}">{{ $listofdepartments[$researchgroup->department_id] }}</a>)</h3>
	<div class="row">
		<div class="col-sm-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
			    	<h3 class="panel-title">Informationen</h3>
			    </div>
			    <div class="panel-body">
					{{ Form::model($researchgroup, ['method' => 'PATCH', 'route' => ['researchgroups.update', $researchgroup->id]]) }}
					<table class="table table-striped">
						<tbody>
							<tr>
								<td>{{ Form::label('short', 'Kürzel*:') }}</td>
								<td align="right">{{ Form::text('short',$researchgroup->short, array('size' => 40)) }}</td>
							</tr>
							<tr>
								<td>{{ Form::label('name', 'Name*:') }}</td>
								<td align="right">{{ Form::text('name', $researchgroup->name, array('size' => 40)) }}</td>
							</tr>
							<tr>
								<td>{{ Form::label('department_id', 'Fachbereich:') }}</td>
								<td align="right">{{ Form::select('department_id', $listofdepartments, $researchgroup->department_id) }}</td>
							</tr>
							<tr>
								<td>* erforderlich</td>
								<td align="right">{{ Form::submit('Bearbeiten') }}</td>
							</tr>
						</tbody>
					</table>
					{{ Form::close() }}
				</div>
			</div>
		</div>
		
		<div class="col-sm-6">
				<div class="panel panel-primary">
		        	<div class="panel-heading">
		              <h3 class="panel-title">Mitarbeiter</h3>
		            </div>
		            <div class="panel-body">
		            	@if ( !$employees->count() )
							Dem Arbeitsbereich sind bisher keine Mitarbeiter zugeordnet.
						@else
							<div class="table-responsive">
					            <table class="table table-striped" cellspacing="0">
					            	<thead>
						                <tr>
						                	<th>Name</th>
						                   	<th>Lehrdeputat</th>
						                  	<th>Angestellt seit</th>
						                  	<th>Angestellt bis</th>
						                </tr>
					              	</thead>
					              	<tbody>
										@foreach( $employees as $employee )
											<tr>
												<td><a href="{{ route('employees.show', $employee->id) }}">{{ $employee->firstname }} {{ $employee->name }}</a></td>
												<td>{{ $employee->teaching_load }} SWS</td>
												<td>{{ $employee->employed_since }}</td>
												<td>{{ $employee->employed_till }}</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						@endif
					</div>
				</div>
			</div>
	</div>
	
	<div class="row">
        <div class="col-sm-12">
			<div class="panel panel-primary">
		       	<div class="panel-heading">
		    	    <h3 class="panel-title">Veranstaltungen</h3>
		        </div>
		        <div class="panel-body">
		        	<div class="table-responsive">
						<table class="table table-striped" cellspacing="0">
						    <thead>
								<tr>
								    <th>Veranstaltung</th>
								    <th>Verantwortliche</th>
								    <th>Semester</th>
								    <th>SWS</th>
								    <th>Uhrzeit</th>
								    <th>Raum</th>
							 	</tr>
						   	</thead>
						    <tbody>
											
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>	
    </div>
@stop