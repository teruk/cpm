@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li><a href="{{ URL::to('turns')}}">Semestermanagement</a></li>
	  <li class="active">{{ $turn->name }} {{ $turn->year }}</li>
	</ol>
@stop

@section('main')
	<h3>{{ $turn->name }} {{ $turn->year }}</h3>
	<div class="row">
		<div class="col-sm-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
			    	<h3 class="panel-title">Informationen</h3>
			    </div>
			    <div class="panel-body">
					{{ Form::model($turn, ['method' => 'PATCH', 'route' => ['turns.update', $turn->id]]) }}
					<table class="table table-striped">
						<tbody>
							<tr>
								<td>{{ Form::label('name', 'Semester*:') }}</td>
								<td align="right">{{ $turn->name }} {{ $turn->year }}</td>	
							</tr>
							<tr>
								<td>{{ Form::label('semester_start', 'Semesterbeginn*:') }}</td>
								<td align="right">{{ Form::input('date', 'semester_start') }}</td>	
							</tr>
							<tr>
								<td>{{ Form::label('semester_end', 'Semesterende*:') }}</td>
								<td align="right">{{ Form::input('date', 'semester_end') }}</td>	
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
	</div>
@stop