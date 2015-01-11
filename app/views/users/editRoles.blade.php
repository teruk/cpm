@extends('layouts.main')

@include('users.partials.breadcrumb', ['breadcrumbTitle' => 'Rollen zuordnen'])

@section('main')
	
	<div class="row">
		@include('users.partials.sidenav')

		<div class="col-md-9">
			@include('users.partials.heading', ['title' => 'Rollen zuordnen:'])

			<p>Bearbeitung der Informationen dieses Benutzers.</p>
			<div class="panel panel-default">
	            <div class="panel-body">
	            	<div class="table-responsive">
	            		<table class="table table-striped table-condensed">
            				<thead>
		            			<tr>
		            				<th>Rolle</th>
		            				<th>Option</th>
		            			</tr>
		            		</thead>
		            		<tbody>	
				            	@if ( $user->roles->count() == 0 )
				            		<tr>
										<td colspan="2">Diesem Benutzer sind keine Rollen zugeordnet.</td>
									</tr>
								@else
									@foreach($user->roles as $role)
										<tr>
											<td>{{ $role->name }}</td>
											<td>
												@if ($currentUser->can('detach_user_role') || $currentUser->hasRole('Admin'))
													@if ($currentUser->id != $user->id)
														{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('detachRoleUser_path', $user->id))) }}
														{{ Form::hidden('role_id', $role->id) }}
														{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-danger', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Zuordnung löschen')) }}
														{{ Form::close() }}
													@else
														@if($role->name != "Admin")
															{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('detachRoleUser_path', $user->id))) }}
															{{ Form::hidden('role_id', $role->id) }}
															{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-danger', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Zuordnung löschen')) }}
															{{ Form::close() }}
														@endif
													@endif
												@endif
											</td>
										</tr>
									@endforeach
								@endif
							</tbody>
							@if($currentUser->can('attach_user_role') || $currentUser->hasRole('Admin'))
								<tfoot>
									<tr>
										<th colspan="2">Rolle zuordnen:</th>
									</tr>
									<tr>
										{{ Form::model($user, ['method' => 'PATCH', 'route' => ['attachRoleUser_path',$user->id]]) }}
										<td>{{ Form::select('role_id', $availableRoles, null, array('class' => 'form-control input-sm')) }} </td>
										<td>
											{{ Form::button('<i class="glyphicon glyphicon-plus"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-success', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Rolle zuordnen')) }}
											{{ Form::close() }}
										</td>
									</tr>
								</tfoot>
							@endif
						</table>
	            	</div>
	            	
				</div>
			</div>
		</div>
	</div>
@stop