@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li>{{ link_to_route('showPermissions_path', 'Berechtigungsmanagement') }}</li>
	  <li class="active">{{ $permission->display_name }}</li>
	</ol>
@stop

@section('main')
	<div class="alert alert-dismissable alert-danger">
	  	<h4>Hinweis!</h4>
	  	<p>Vorsicht bei Änderungen. Sollten nur von geschultem Personal vorgenommen werden.</p>
	</div>
	<div class="row">
		<div class="col-sm-8">
			<div class="panel panel-primary">
	            <div class="panel-body">
					{{ Form::model($permission, ['method' => 'PATCH', 'route' => ['updatePermission_path', $permission->id], 'class' => "form-horizontal"]) }}
					<legend>Berechtigung aktualisieren</legend>
					<div class="form-group">
        				{{ Form::label('display_name', 'Anzeigename*:', array('class' => "col-lg-3 control-label", 'id' => "display_name")) }}
        				<div class="col-lg-9">
        					{{ Form::input('text', 'display_name', $permission->display_name, array('id' => "display_name", 'min' => 2, 'placeholder' => 'Rollenname', 'required' => true, 'class' => "form-control input-sm")) }}
        				</div>
	        		</div>
	        		<div class="form-group">
        				{{ Form::label('name', 'Name*:', array('class' => "col-lg-3 control-label", 'id' => "name")) }}
        				<div class="col-lg-9">
        					{{ Form::input('text', 'name', $permission->name, array('id' => "name", 'min' => 2, 'placeholder' => 'Rollenname', 'required' => true, 'class' => "form-control input-sm")) }}
        				</div>
	        		</div>
	        		<div class="form-group">
	    				{{ Form::label('description', 'Beschreibung:', array('class' => "col-lg-3 control-label", 'id' => "description")) }}
	    				<div class="col-lg-9">
	    					{{ Form::textarea('description', $permission->description, array('id' => "description", 'class' => "form-control input-sm", 'placeholder' => 'Rollenbeschreibung ...', 'rows'=>5, 'style' => 'resize:none;')) }}
	    				</div>
	    			</div>
	        		<div class="form-group">
      					<div class="col-lg-9 col-lg-offset-3" style="text-align: right">
      					@if (Entrust::hasRole('Admin') || Entrust::can('edit_permission'))
	      					*erforderlich
	      					{{ Form::button('<i class="glyphicon glyphicon-refresh"></i> Aktualisieren', array('type' => 'submit', 'class' => 'btn btn-sm btn-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Informationen aktualisieren')) }}
	      					{{ Form::hidden('tabindex', 'home') }}
	      				@endif
      					</div>
      				</div>
					{{ Form::close() }}
				</div>
			</div>
		</div>

		<div class="col-sm-4">
			<div class="panel panel-primary">
	            <div class="panel-body">
	            	<table class="table table-striped table-condensed">
	            		<thead>
	            			<tr>
	            				<th>Rollen mit dieser Berechtigung:</th>
	            			</tr>
	            		</thead>
	            		<tbody>
							@foreach ($permission->roles as $role)
								<tr>
									<td><a href="{{ route('roles.show', $role->id) }}">{{ $role->name }}</a></td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

@stop