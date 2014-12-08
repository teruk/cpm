@section('scripts')
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
		<li class="active">Administration</li>
		<li class="active">Einstellungen</li>
	</ol>
@stop

@section('main')
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-primary">
	            <div class="panel-body">
					{{ Form::model(new Turn, ['method' => 'PATCH', 'route' => ['settings.updateCurrentTurn'], 'class' => "form-horizontal"]) }}
						<fieldset>
							<legend>Aktuelles Semester</legend>
							<div class="form-group">
		        				{{ Form::label('current_turn', 'Aktuelles Semester:', array('class' => "col-lg-4 control-label", 'id' => "current_turn")) }}
		        				<div class="col-lg-8">
		        					{{ Form::select('current_turn', $listofturns, Setting::setting('current_turn')->first()->value, array('id' => "current_turn", 'class' => 'form-control input-sm')) }}
		        				</div>
			        		</div>

			        		<div class="form-group">
		      					<div class="col-lg-8 col-lg-offset-4" style="text-align: right">
			      					@if (Entrust::hasRole('Admin') || Entrust::can('change_setting_current_turn'))
				      					{{ Form::button('<i class="glyphicon glyphicon-refresh"></i> Aktualisieren', array('type' => 'submit', 'class' => 'btn btn-sm btn-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Aktuelles Semester aktualisieren')) }}
				      				@endif
		      					</div>
		      				</div>
		        		</fieldset>	
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
@stop