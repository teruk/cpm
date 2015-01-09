@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li>{{ link_to_route('showRooms_path','Raummanagement') }}</li>
	  <li class="active">{{ $room->name }}</li>
	</ol>
@stop

@section('main')
	<h3>{{ $room->name }}</h3>
	
	<div class="row">
		<div class="col-sm-7">
			<div class="panel panel-primary">
		       	<div class="panel-heading">
			        <h3 class="panel-title">Informationen</h3>
		        </div>
		        <div class="panel-body">
					{{ Form::model($room, ['method' => 'PATCH', 'route' => ['updateRoom_path', $room->id]]) }}
					<table class="table table-striped">
						<tbody>
							<tr>
								<td>{{ Form::label('name', 'Name*:') }}</td>
								<td align="right">{{ Form::text('name', $room->name, array('size' => 40)) }}</td>	
							</tr>
							<tr>
								<td>{{ Form::label('location', 'Ort*:') }}</td>
								<td align="right">{{ Form::text('location', $room->location, array('size' => 35)) }}</td>
							</tr>
							<tr>
								<td>{{ Form::label('seats', 'Plätze*:') }}</td>
								<td align="right">{{ Form::input('number', 'seats', $room->seats, array('min' => 1)) }}</td>
							</tr>
							<tr>
								<td>{{ Form::label('room_type_id', 'Raumtyp*:') }}</td>
								<td align="right">{{ Form::select('room_type_id', $listofroomtypes, $room->room_type_id) }}</td>
							</tr>
							
							<tr>
								<td>{{ Form::label('beamer', 'Beamer*:') }}</td>
								<td align="right">{{ Form::checkbox('beamer', 1, $room->beamer) }}</td>
							</tr>
							<tr>
								<td>{{ Form::label('blackboard', 'Tafel*:') }}</td>
								<td align="right">{{ Form::checkbox('blackboard', 1, $room->blackboard) }}</td>
							</tr>
							<tr>
								<td>{{ Form::label('overheadprojector', 'Overheadprojektor*:') }}</td>
								<td align="right">{{ Form::checkbox('overheadprojector', 1, $room->overheadprojector) }}</td>
							</tr>
							<tr>
								<td>{{ Form::label('accessible', 'Behindertengerecht*:') }}</td>
								<td align="right">{{ Form::checkbox('accessible', 1, $room->accessible) }}</td>
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