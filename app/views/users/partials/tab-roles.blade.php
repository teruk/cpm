@if ($user->id == Entrust::user()->id && $user->hasRole('Admin'))
	<div class="alert alert-dismissable alert-danger">
	  	<h4>Hinweis!</h4>
	  	<p>Aus Sicherheitsgründen können Sie sich die Adminstrator-Rolle nicht selbst entziehen!</p>
	</div>
@endif
<div class="row">
	<div class="col-sm-8">
		<div class="panel panel-primary">
            
            <div class="panel-body">
            	<table class="table table-striped table-condensed">
            		<thead>
            			<tr>
            				<th>Rolle</th>
            				<!-- <th>Rechte</th> -->
            				<th>Option</th>
            			</tr>
            		</thead>
            		<tbody>	
		            	@if ( !$user->roles->count() )
		            		<tr>
								<td colspan=3>Diesem Benutzer sind keine Rollen zugeordnet.</td>
							</tr>
						@else
							@foreach($user->roles as $role)
								<tr>
									<td>{{ $role->name }}</td>
									<!-- <td>
										@foreach($role->perms as $perm)
											{{ $perm->display_name }}<br>
										@endforeach
									</td> -->
									<td>
										@if (Entrust::can('detach_user_role') || Entrust::hasRole('Admin'))
											@if (Entrust::user()->id != $user->id)
												{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('detachRoleUser_path', $user->id))) }}
												{{ Form::hidden('role_id', $role->id) }}
												{{ Form::hidden('tabindex', "roles") }}
												{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-danger', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Zuordnung löschen')) }}
												{{ Form::close() }}
											@else
												@if($role->name != "Admin")
													{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('detachRoleUser_path', $user->id))) }}
													{{ Form::hidden('role_id', $role->id) }}
													{{ Form::hidden('tabindex', "roles") }}
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
					@if(Entrust::can('attach_user_role') || Entrust::hasRole('Admin'))
					<tfoot>
						<tr>
							<th colspan="2">Rolle zuordnen:</th>
						</tr>
						<tr>
							{{ Form::model($user, ['method' => 'PATCH', 'route' => ['attachRoleUser_path',$user->id]]) }}
							<td>{{ Form::select('role_id', $available_roles, null, array('class' => 'form-control input-sm')) }} </td>
							<!-- <td></td> -->
							<td>
								{{ Form::button('<i class="glyphicon glyphicon-plus"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-success', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Rolle zuordnen')) }}
								{{ Form::hidden('tabindex', "roles") }}
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