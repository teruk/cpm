@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li>{{ link_to_route('showAppointeddays_path', 'Termine') }}</li>
	  <li class="active">{{ $appointedday->subject }}</li>
	</ol>
@stop

@section('main')	
	<div class="row">
		<div class="col-sm-8">
			<div class="panel panel-primary">
		        <div class="panel-body">
					{{ Form::model($appointedday, ['method' => 'PATCH', 'route' => ['updateAppointedday_path', $appointedday->id], 'class' => "form-horizontal"]) }}
			        <fieldset>
			        	<legend>Termin aktualisieren</legend>
			        	<div class="form-group">
		        			{{ Form::label('subject', 'Betreff*:', array('class' => "col-lg-3 control-label", 'id' => "subject")) }}
		        			<div class="col-lg-9">
		        				{{ Form::input('text', 'subject', $appointedday->subject, array('id' => "subject", 'min' => 3, 'placeholder' => 'Betreff', 'required' => true, 'class' => "form-control input-sm")) }}
		        			</div>
			        	</div>

			        	<!-- <div class="form-group">
		        			{{ Form::label('date', 'Aktuelles Datum*:', array('class' => "col-lg-4 control-label", 'id' => "date")) }}
		        			<div class="col-lg-8">
		        				{{ date('d.m.Y', strtotime($appointedday->date)) }}
		        			</div>
			        	</div> -->

			        	<div class="form-group">
		        			{{ Form::label('date', 'Datum*:', array('class' => "col-lg-3 control-label", 'id' => "date")) }}
		        			<div class="col-lg-9">
		        				{{ Form::input('date', 'date', date('Y-m-d', strtotime($appointedday->date)), array('id' => "date", 'class' => "form-control input-sm")) }}
		        			</div>
			        	</div>
			        	
			        	<div class="form-group">
			        		{{ Form::label('content', 'Ankündigung*:', array('class' => "col-lg-3 control-label", 'id' => "content")) }}
			        		<div class="col-lg-9">
			        			{{ Form::textarea('content', $appointedday->content, array('id' => "content", 'placeholder' => 'Ankündigungstext', 'class' => "form-control input-sm", 'rows'=>10, 'style' => 'resize:none;')) }}
			        		</div>
			        	</div>
			        	
			        	<div class="form-group">
		      				<div class="col-lg-9 col-lg-offset-3" style="text-align: right">
								{{ Form::button('<i class="glyphicon glyphicon-refresh"></i> Aktualisieren', array('type' => 'submit', 'class' => 'btn btn-sm btn-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Informationen aktualisieren')) }}
		      				</div>
		      			</div>
			        </fieldset>
				</div>
			</div>
		</div>
	</div>
@stop