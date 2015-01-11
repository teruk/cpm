@extends('layouts.main')

@include('roles.partials.breadcrumb', ['breadcrumbTitle' => 'Informationen bearbeiten'])

@section('main')
	
	<div class="row">
		@include('roles.partials.sidenav')

		<div class="col-md-9">
			@include('roles.partials.heading', ['title' => 'Informationen bearbeiten:'])

			<p>Bearbeitung der Informationen dieses Studiengangs.</p>

			<div class="panel panel-default">
			            
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
	            			{{ Form::model($role, ['method' => 'PATCH', 'route' => ['updatePermission_path',$role->id]]) }}
							@foreach($role->perms as $perm)
								<tr>
									<td>{{ Form::checkbox($perm->name, 1, true) }}</td>
									<td>{{ $perm->display_name }}</td>
									<td>{{ $perm->description }}</td>
								</tr>
							@endforeach
							@foreach($availablePermissions as $p)
								<tr>
									<td>{{ Form::checkbox($p->name, 1, false) }}</td>
									<td>{{ $p->display_name }}</td>
									<td>{{ $p->description }}</td>
								</tr>
							@endforeach
						</tbody>
						@if(Entrust::can('attach_role_permission') || Entrust::hasRole('Admin'))
							<tfoot>
								<tr>
									<th colspan="3">Zuordnung aktualisieren:</th>
								</tr>
								<tr>
									<td colspan="3" align="right">
										{{ Form::button('<i class="glyphicon glyphicon-refresh"></i> Aktualisieren', array('type' => 'submit', 'class' => 'btn btn-sm btn-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Informationen aktualisieren')) }}
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
@stop