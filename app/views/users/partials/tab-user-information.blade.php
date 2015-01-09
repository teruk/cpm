<div class="row">
	<div class="col-sm-7">
		<div class="panel panel-primary">
            <div class="panel-body">
				{{ Form::model($user, ['method' => 'PATCH', 'route' => ['updateUser_path', $user->id], 'class' => "form-horizontal"]) }}
				<fieldset>
					<legend>Benutzer aktualisieren</legend>
					<div class="form-group">
        				{{ Form::label('name', 'Name*:', array('class' => "col-lg-3 control-label", 'id' => "name")) }}
        				<div class="col-lg-9">
        					{{ Form::input('text', 'name', $user->name, array('id' => "name", 'min' => 2, 'placeholder' => 'Name','required'=>true, 'class' => 'form-control input-sm')) }}
        				</div>
	        		</div>

	        		<div class="form-group">
	    				{{ Form::label('email', 'Email*:', array('class' => "col-lg-3 control-label", 'id' => "email")) }}
	    				<div class="col-lg-9">
	    					{{ Form::input('email','email', $user->email, array('id' => "email", 'placeholder' => 'Email-Adresse','required'=>true, 'class' => 'form-control input-sm')) }}
	    				</div>
	    			</div>

	    			<div class="form-group">
        				{{ Form::label('password', 'Passwort:', array('class' => "col-lg-3 control-label", 'id' => "password")) }}
        				<div class="col-lg-9">
        					{{ Form::input('text', 'password', $user->password, array('class' => 'form-control input-sm', 'disabled' => "")) }}
        				</div>
	        		</div>

	        		<div class="form-group">
      					<div class="col-lg-9 col-lg-offset-3" style="text-align: right">
      					@if (Entrust::hasRole('Admin') || Entrust::can('edit_user'))
	      					*erforderlich
	      					{{ Form::button('<i class="glyphicon glyphicon-refresh"></i> Aktualisieren', array('type' => 'submit', 'class' => 'btn btn-sm btn-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Informationen aktualisieren')) }}
	      					{{ Form::hidden('tabindex', 'home') }}
	      				@endif
      					</div>
      				</div>
				</fieldset>
				{{ Form::close() }}
			</div>
		</div>
	</div>

	<div class="col-sm-5">
		<div class="panel panel-primary">
            <div class="panel-body">
				<table class="table table-striped table-condensed">
					<thead>
						<tr>
							<th>Rolle</th>
							<!-- <th>Rechte</th> -->
						</tr>
					</thead>
					<tbody>
						@if ($user->roles->count())
							@foreach($user->roles as $role)
								<tr>
									<td>{{ $role->name }}</td>
									<!-- <td>
										@foreach($role->perms as $perm)
											{{ $perm->display_name }}<br>
										@endforeach
									</td> -->
								</tr>
							@endforeach
						@else
							<tr>
								<td colspan="2">Keine Rolle zugeordnet!</td>
							</tr>
						@endif
					</tbody>
					<thead>
						<tr>
							<th colspan=2>Arbeitsbereich</th>
						</tr>
					</thead>
					<tbody>
						@if ($user->researchgroups->count())
							@foreach($user->researchgroups as $researchgroup)
								<tr>
									<td colspan="2">{{ $researchgroup->name }} ({{ $researchgroup->short }})</td>
								</tr>
							@endforeach
						@else
							<tr>
								<td colspan="2">Keine Arbeitsbereiche zugeordnet!</td>
							</tr>
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>