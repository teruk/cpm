@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li><a href="{{ URL::to('degrees')}}">Abschlussmanagement</a></li>
	  <li class="active">{{ $degree->name }}</li>
	</ol>
@stop

@section('main')
	<h3>{{ $degree->name }}</h3>
	
	<div class="row">
		<div class="col-sm-6">
			<div class="panel panel-primary">
		       	<div class="panel-heading">
			        <h3 class="panel-title">Informationen</h3>
		        </div>
		        <div class="panel-body">
					{{ Form::model($degree, ['method' => 'PATCH', 'route' => ['degrees.update', $degree->id]]) }}
					<table class="table table-striped">
						<tbody>
							<tr>
								<td>{{ Form::label('name', 'Name*:') }}</td>
								<td align="right">{{ Form::text('name', $degree->name, array('size' => 40)) }}</td>	
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
@stop