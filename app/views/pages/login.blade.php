@extends('layouts.main')

@section('main')
	<div class="row" >
		<div class="col-sm-6">
			<div class="panel panel-primary">
        		<div class="panel-body">
					{{ Form::open(array('url' => 'login', 'class' => "form-horizontal")) }}
					<fieldset>
						<legend>Login</legend>
						<div class="form-group">
	        				{{ Form::label('email', 'Email:', array('class' => "col-lg-3 control-label", 'id' => "email")) }}
	        				<div class="col-lg-9">
	        					{{ Form::input('email', 'email', Input::old('email'), array('id' => "email", 'placeholder' => 'Name@email.com', 'required' => true, 'class' => "form-control input-sm")) }}
	        				</div>
		        		</div>
		        		<div class="form-group">
	        				{{ Form::label('password', 'Passwort:', array('class' => "col-lg-3 control-label", 'id' => "password")) }}
	        				<div class="col-lg-9">
	        					{{ Form::input('password', 'password', '', array('id' => "password", 'required' => true, 'class' => "form-control input-sm")) }}
	        				</div>
		        		</div>
		        		<div class="form-group">
	      					<div class="col-lg-9 col-lg-offset-3" style="text-align: right">
							{{ Form::submit('Einloggen', array('class' => 'btn btn btn-default')) }}
      					</div>
      				</div>
		        	</fieldset>
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
@stop