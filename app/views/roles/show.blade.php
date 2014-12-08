@section('scripts')
	<script type="text/javascript" class="init">
	   
	</script>
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li><a href="{{ URL::to('roles')}}">Rollenmanagement</a></li>
	  <li class="active">{{ $role->name }}</li>
	</ol>
@stop

@section('main')
	<h3>{{ $role->name }}</h3>
	<ul class="nav nav-tabs" style="margin-bottom: 15px;">
		@if ( $tabindex == "home" )
			<li class="active">
		@else
			<li>
		@endif
		<a href="#home" data-toggle="tab">Informationen</a></li>

		@if ( $tabindex == "permissions" )
			<li class="active">
		@else
			<li>
		@endif
		<a href="#permissions" data-toggle="tab">Berechtigungen</a></li>
	</ul>

	<div id="myTabContent" class="tab-content">
		@if ( $tabindex == "home" )
			<div class="tab-pane fade active in" id="home">
		@else
			<div class="tab-pane fade" id="home">
		@endif
			<div class="row">
				<div class="col-sm-8">
					<div class="panel panel-primary">
			            <div class="panel-body">
							{{ Form::model($role, ['method' => 'PATCH', 'route' => ['roles.update', $role->id], 'class' => "form-horizontal"]) }}
							<fieldset>
								<legend>Rolle aktualisieren</legend>
								<div class="form-group">
			        				{{ Form::label('name', 'Name*:', array('class' => "col-lg-3 control-label", 'id' => "name")) }}
			        				<div class="col-lg-9">
			        					@if ($role->name != "Admin")
			        						{{ Form::input('text', 'name', $role->name, array('id' => "name", 'min' => 2, 'placeholder' => 'Rollenname', 'required' => true, 'class' => "form-control input-sm")) }}
			        					@else
				    						{{ Form::input('text', 'name', $role->name, array('id' => "name", 'min' => 2, 'placeholder' => 'Rollenname', 'required' => true, 'class' => "form-control input-sm", 'disabled' => 'true')) }}
				    					@endif
			        				</div>
				        		</div>
				        		<div class="form-group">
				    				{{ Form::label('description', 'Beschreibung:', array('class' => "col-lg-3 control-label", 'id' => "description")) }}
				    				<div class="col-lg-9">
				    					{{ Form::textarea('description', $role->description, array('id' => "description", 'class' => "form-control input-sm", 'placeholder' => 'Rollenbeschreibung ...', 'rows'=>5, 'style' => 'resize:none;')) }}
				    				</div>
				    			</div>
				        		<div class="form-group">
			      					<div class="col-lg-10 col-lg-offset-2" style="text-align: right">
			      					@if (Entrust::hasRole('Admin') || Entrust::can('edit_role'))
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
			</div>

			<div class="row">
				<div class="col-sm-4">
					<div class="panel panel-primary">
			            <div class="panel-body">
			            	<table class="table table-striped table-condensed">
			            		<thead>
			            			<tr>
			            				<th>Benutzer mit dieser Rolle:</th>
			            			</tr>
			            		</thead>
			            		<tbody>
									@foreach ($role->users as $user)
										<tr>
											<td><a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a></td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<div class="col-sm-4">
					<div class="panel panel-primary">
			            <div class="panel-body">
			            	<table class="table table-striped table-condensed">
			            		<thead>
			            			<tr>
			            				<th>Berechtigungen dieser Rolle:</th>
			            			</tr>
			            		</thead>
			            		<tbody>
									@foreach ($role->perms as $perm)
										<tr>
											<td><a href="{{ route('permissions.show', $perm->id) }}">{{ $perm->display_name }}</a></td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
	        </div>
		</div>

		@if ( $tabindex == "permissions" )
			<div class="tab-pane fade active in" id="permissions">
		@else
			<div class="tab-pane fade" id="permissions">
		@endif
			<div class="row">
				<div class="col-sm-10">
					<div class="panel panel-primary">
			            
			            <div class="panel-body">
			            	<table class="table table-striped table-condensed">
			            		<thead>
			            			<tr>
			            				<th></th>
			            				<th>Rechte</th>
			            				<th>Beschreibung</th>
			            			</tr>
			            		</thead>
			            		<tbody>
			            			{{ Form::model($role, ['method' => 'PATCH', 'route' => ['roles.updatePermission',$role->id]]) }}
									@foreach($role->perms as $perm)
											<!-- <tr>
												<td>{{ $perm->display_name }}</td>
												<td>{{ $perm->description }}</td>
												<td>
													@if (Entrust::can('detach_role_permission') || Entrust::hasRole('Admin'))
														{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('roles.detachPermission', $role->id))) }}
														{{ Form::hidden('permission_id', $perm->id) }}
														{{ Form::hidden('tabindex', "permissions") }}
														{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-danger', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Zuordnung löschen')) }}
														{{ Form::close() }}
													@endif
												</td>
											</tr> -->
											<tr>
												<td>{{ Form::checkbox($perm->name, 1, true) }}</td>
												<td>{{ $perm->display_name }}</td>
												<td>{{ $perm->description }}</td>
												<td></td>
											</tr>
									@endforeach
									@foreach($available_permissions as $p)
										<tr>
											<td>{{ Form::checkbox($p->name, 1, false) }}</td>
											<td>{{ $p->display_name }}</td>
											<td>{{ $p->description }}</td>
											<td></td>
										</tr>
									@endforeach
								</tbody>
								@if(Entrust::can('attach_role_permission') || Entrust::hasRole('Admin'))
								<tfoot>
									<tr>
										<th colspan="4">Zuordnung aktualisieren:</th>
									</tr>
									<tr>
										<!-- <td colspan="3">{{ Form::select('permission_id', $available_permissions, null, array('class' => 'form-control input-sm')) }} </td> -->
										<td colspan="3" align="right">
											<!-- {{ Form::button('<i class="glyphicon glyphicon-plus"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-success', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Berechtigung zuordnen')) }} -->
											{{ Form::button('<i class="glyphicon glyphicon-refresh"></i> Aktualisieren', array('type' => 'submit', 'class' => 'btn btn-sm btn-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Informationen aktualisieren')) }}
											{{ Form::hidden('tabindex', "permissions") }}
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
	</div>
@stop