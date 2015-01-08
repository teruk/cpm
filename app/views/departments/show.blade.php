@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li>{{ link_to_route('showDepartments_path', 'Fachbereichsmanagement') }}</li>
	  <li class="active">{{ $department->name }}</li>
	</ol>
@stop

@section('main')
	<h3>{{ $department->name }}</h3>
	<div class="row">
			<div class="col-sm-6">
				<div class="panel panel-primary">
		        	<div class="panel-heading">
		              <h3 class="panel-title">Informationen</h3>
		            </div>
		            <div class="panel-body">
						{{ Form::model($department, ['method' => 'PATCH', 'route' => ['updateDepartment_path', $department->id]]) }}
							<table class="table table-striped">
								<tbody>
									<tr>
										<td>{{ Form::label('short', 'Kürzel*:') }}</td>
										<td align="right">{{ Form::text('short',$department->short, array('size' => 40)) }}</td>
										
									</tr>
									<tr>
										<td>{{ Form::label('name', 'Titel*:') }}</td>
										<td align="right">{{ Form::text('name', $department->name, array('size' => 40)) }}</td>	
									</tr>							 
									<tr>
										<td >* erforderlich</td>
										<td align="right">{{ Form::submit('Bearbeiten') }}</td>
									</tr>
								</tbody>
							</table>
						{{ Form::close() }}
					</div>
				</div>
			</div>
			
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="panel panel-primary">
		        	<div class="panel-heading">
		              <h3 class="panel-title">Arbeitsbereiche</h3>
		            </div>
		            <div class="panel-body">
						<table class="table table-striped">
							<tbody>
								@if ( sizeof($researchgroups) > 0 )
									@foreach($researchgroups as $researchgroup)
									<tr>
										<td><a href="{{ route('researchgroups.show', [$researchgroup->id]) }}">{{$researchgroup->name}}</a></td>
									</tr>
									@endforeach
								@else
									Keine Arbeitsbereiche zugeordnet.
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="panel panel-primary">
		        	<div class="panel-heading">
		              <h3 class="panel-title">Studiengänge</h3>
		            </div>
		            <div class="panel-body">
						<table class="table table-striped">
							<tbody>
								@if ( sizeof($degreecourses) > 0 )
									@foreach($degreecourses as $degreecourse)
									<tr>
										<td>{{ link_to_route('showDegreecourse_path', $degreecourse->degree->name.' '.$degreecourse->name, $degreecourse->id ) }}</td>
									</tr>
									@endforeach
								@else
									Keine Studiengänge zugeordnet.
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
@stop