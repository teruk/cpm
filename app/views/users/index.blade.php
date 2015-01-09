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
	<!-- <h3>Benutzermanagement
		<button class="btn btn-success btn-xs" >
	  	<span class="glyphicon glyphicon-plus"></span>
		</button>
	</h3> -->
	@if (Entrust::hasRole('Admin') || Entrust::can('add_user'))
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
		    					<td>{{ link_to_route('showUser_path', $user->name, $user->id) }}</td>
		    					<!-- <td>{{ $user->username }}</td> -->
		    					<td>{{ $user->email }}</td>
		    					<!-- <td>{{ $user->password }}</td> -->
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
		    						{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('deleteUser_path', $user->id))) }}
		    						{{ HTML::decode(link_to_route('showUser_path', '<i class="glyphicon glyphicon-edit"></i>', array($user->id), array('class' => 'btn btn-xs btn-warning'))) }}
		    						@if((Entrust::hasRole('Admin') || Entrust::can('delete_user')) && !$user->hasRole('Admin'))
		    							{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'button', 'class' => 'btn btn-xs btn-danger', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Benutzer löschen', 'data-message' => 'Wollen Sie den Benutzer wirklich löschen?')) }}
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

	<!-- add form dialog -->
	@include('users.partials.add-form')

	<!-- delete confirmation modal dialog -->
	@include('layouts.partials.delete_confirm')
@stop