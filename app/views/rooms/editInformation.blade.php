@extends('layouts.main')

@include('rooms.partials.breadcrumb', ['breadcrumbTitle' => 'Informationen bearbeiten'])

@section('main')
	
	<div class="row">
		@include('rooms.partials.sidenav')

		<div class="col-md-9">
			@include('rooms.partials.heading', ['title' => 'Informationen bearbeiten:'])

			<p>Bearbeitung der Informationen dieses Raums.</p>

			<div class="panel panel-default">
		        <div class="panel-body">
					{{ Form::model($room, ['method' => 'PATCH', 'route' => ['updateRoom_path', $room->id], 'class' => "form-horizontal"]) }}

					<div class="form-group">
						{{ Form::label('name', 'Name*:', ['class' => 'col-md-2 control-label']) }}
						<div class="col-md-10">
							{{ Form::text('name', $room->name, array('id' => "name", 'min' => 3, 'placeholder' => 'Name','required'=>true, 'class' => 'form-control input-sm')) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('location', 'Ort*:', ['class' => 'col-md-2 control-label']) }}
						<div class="col-md-4">
							{{ Form::text('location', $room->location, array('id' => "location", 'min' => 3, 'placeholder' => 'z.B. Ort','required'=>true, 'class' => 'form-control input-sm')) }}
						</div>

						{{ Form::label('seats', 'Plätze*:', ['class' => 'col-md-2 control-label']) }}
						<div class="col-md-4">
							{{ Form::input('number', 'seats', $room->seats, array('id' => "seats", 'min' => 0, 'step' => 1, 'required'=>true, 'class' => 'form-control input-sm')) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('roomtype_id', 'Raumtyp*:', ['class' => 'col-md-2 control-label']) }}
						<div class="col-md-4">
							{{ Form::select('roomtype_id', $listofroomtypes, $room->roomtype_id, array('id' => "roomtype_id", 'required'=>true, 'class' => 'form-control input-sm')) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('beamer', 'Beamer*:', ['class' => 'col-md-2 control-label']) }}

						<div class="col-md-4">
							{{ Form::checkbox('beamer', 1, $room->beamer, array('id' => "beamer", 'class' => 'form-control input-sm')) }}
						</div>

						{{ Form::label('overheadprojector', 'Overheadprojektor*:', ['class' => 'col-md-2 control-label']) }}
						<div class="col-md-4">
							{{ Form::checkbox('overheadprojector', 1, $room->overheadprojector, array('id' => "overheadprojector", 'class' => 'form-control input-sm')) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('blackboard', 'Tafel*:', ['class' => 'col-md-2 control-label']) }}
						<div class="col-md-4">
							{{ Form::checkbox('blackboard', 1, $room->blackboard, array('id' => "blackboard", 'class' => 'form-control input-sm')) }}
						</div>

						{{ Form::label('accessible', 'Behindertengerecht*:', ['class' => 'col-md-2 control-label']) }}
						<div class="col-md-4">
							{{ Form::checkbox('accessible', 1, $room->accessible, array('id' => "accessible", 'class' => 'form-control input-sm')) }}
						</div>
					</div>

					<div class="form-group">
      					<div class="col-md-10 col-lg-offset-2" style="text-align: right">
      					@if ($currentUser->hasRole('Admin') || $currentUser->can('edit_room'))
	      					*erforderlich
	      					{{ Form::button('<i class="glyphicon glyphicon-refresh"></i> Aktualisieren', array('type' => 'submit', 'class' => 'btn btn-sm btn-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Informationen aktualisieren')) }}
	      				@endif
      					</div>
      				</div>
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
@stop