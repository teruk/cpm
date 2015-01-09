@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li>{{ link_to_route('showRoomtypes_path', 'Raumtypmanagement') }}</li>
	  <li class="active">{{ $roomtype->name }}</li>
	</ol>
@stop

@section('main')
	<h3>{{ $roomtype->name }}</h3>
	
	<div class="row">
		<div class="col-sm-7">
			<div class="panel panel-primary">
		       	<div class="panel-heading">
			        <h3 class="panel-title">Informationen</h3>
		        </div>
		        <div class="panel-body">
					{{ Form::model($roomtype, ['method' => 'PATCH', 'route' => ['updateRoomtype_path', $roomtype->id]]) }}
					<table class="table table-striped">
						<tbody>
							<tr>
								<td>{{ Form::label('name', 'Name*:') }}</td>
								<td align="right">{{ Form::text('name', $roomtype->name, array('size' => 48)) }}</td>	
							</tr>		
							<tr>
								<td>{{ Form::label('desciption', 'Beschreibung*:') }}</td>
								<td align="right">{{ Form::textarea('description', $roomtype->description, array('style' => 'resize:none')) }}</td>	
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