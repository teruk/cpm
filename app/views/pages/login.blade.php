@extends('layouts.main')

@section('main')
	<div class="row" >
		<div class="col-md-6">
			<div class="panel panel-default">
        		<div class="panel-body">
					{{ Form::open(array('url' => 'login', 'class' => "form-horizontal")) }}
					<fieldset>
						<legend>Login</legend>
						<div class="form-group">
	        				{{ Form::label('email', 'Email:', array('class' => "col-md-3 control-label", 'id' => "email")) }}
	        				<div class="col-md-9">
	        					{{ Form::input('email', 'email', Input::old('email'), array('id' => "email", 'placeholder' => 'Name@email.com', 'required' => true, 'class' => "form-control input-sm")) }}
	        				</div>
		        		</div>
		        		<div class="form-group">
	        				{{ Form::label('password', 'Passwort:', array('class' => "col-md-3 control-label", 'id' => "password")) }}
	        				<div class="col-md-9">
	        					{{ Form::input('password', 'password', '', array('id' => "password", 'required' => true, 'class' => "form-control input-sm")) }}
	        				</div>
		        		</div>
		        		<div class="form-group">
	      					<div class="col-md-9 col-md-offset-3" style="text-align: right">
							{{ Form::submit('Einloggen', array('class' => 'btn btn btn-default')) }}
      					</div>
      				</div>
		        	</fieldset>
					{{ Form::close() }}
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<p>Folgende Accounts stehen zum Testen zur Verfügung:</p>
			<table class="table table-striped table-condensed">
				<thead>
					<tr>
						<th>Username</th>
						<th>Rolle</th>
						<th>Passwort</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>lp@lpm.de</td>
						<td>Lehrplanung</td>
						<td>passwort</td>
					</tr>
					<tr>
						<td>rp@lpm.de</td>
						<td>Raumplanung</td>
						<td>passwort</td>
					</tr>
					<tr>
						<td>test@lpm.de</td>
						<td>Lokale Lehrplanung</td>
						<td>passwort</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
@stop