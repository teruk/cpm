@extends('layouts.main')

@section('scripts')
	@include('layouts.partials.datatables-script')
	<script type="text/javascript" class="init">

		$(document).ready(function() {
			$('#data_table').dataTable({
				"pagingType": "full"
			});

			$('div.dataTables_filter input').focus()
		} );
	</script>

	@include('layouts.partials.delete-confirm-js')
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li class="active">Benutzermanagement</li>
	</ol>
@stop

@section('main')
	@if ($currentUser->hasRole('Admin') || $currentUser->can('add_user'))
		@include('layouts.partials.add-button-modal', ['buttonLabel' => 'Benutzer hinzufügen'])
	@endif
	       	
	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">
			<div  class="table-responsive">
		       	<table class="table table-striped" id="data_table" cellspacing="0">
		       		<thead>
		       			<tr>
		       				<th>Name</th>
		       				<!-- <th>Username</th> -->
		       				<th>Email</th>
		       				<!-- <th>Passwort</th> -->
		       				<th>Rollen</th>
		       				<th>Deaktiviert</th>
		       				<th>Letzter Login</th>
		       				<th>Option</th>
		       			</tr>
		       		</thead>
		       		<tbody>
						@foreach( $users as $user )
				
							<tr>
		    					<td>
		    						@if ($currentUser->hasRole('Admin') || $currentUser->can('edit_user'))
		    							{{ link_to_route('editUserInformation_path', $user->name, $user->id) }}
		    						@else
		    							{{ $user->name }}
		    						@endif
		    					</td>
		    					<td>{{ $user->email }}</td>
		    					<td>
		    						@foreach ($user->roles as $role)
		    							{{ $role->name }}<br>
		    						@endforeach
		    					</td>
		    					<td>
		    						@if($user->deactivated == 0)
		    							nein
		    						@else
		    							ja
		    						@endif
		    					</td>
		    					<td>{{ date('d.m.Y', strtotime($user->last_login)) }}</td>
		    					<td>
		    						@if(($currentUser->hasRole('Admin') || $currentUser->can('delete_user')) && !$user->hasRole('Admin'))
			    						{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('deleteUser_path', $user->id))) }}
			    							{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'button', 'class' => 'btn btn-xs btn-danger', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Benutzer löschen', 'data-message' => 'Wollen Sie den Benutzer wirklich löschen?')) }}
			    						{{ Form::close() }}
		    						@endif
		    					</td>
							</tr>
						
						@endforeach	
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- add form dialog -->
	@include('users.partials.add-form')

	<!-- delete confirmation modal dialog -->
	@include('layouts.partials.delete_confirm')
@stop