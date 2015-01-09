@include('courses.partials.breadcrumb', ['breadcrumbTitle' => 'Informationen bearbeiten'])

@section('main')
	
	<div class="row">
		@include('courses.partials.sidenav')

		<div class="col-md-9">
			@include('courses.partials.heading', ['title' => 'Information bearbeiten:'])

			<p>Hier kann der ausgewählte Termin bearbeitet werden.</p>
			<div class="panel panel-default">
		        <div class="panel-body">
					{{ Form::model($appointedday, ['method' => 'PATCH', 'route' => ['updateAppointedday_path', $appointedday->id], 'class' => "form-horizontal"]) }}
			        <fieldset>
			        	<legend>Termin aktualisieren</legend>
			        	<div class="form-group">
		        			{{ Form::label('subject', 'Betreff*:', array('class' => "col-md-2 control-label", 'id' => "subject")) }}
		        			<div class="col-md-10">
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
		        			{{ Form::label('date', 'Datum*:', array('class' => "col-md-2 control-label", 'id' => "date")) }}
		        			<div class="col-md-10">
		        				{{ Form::input('date', 'date', date('Y-m-d', strtotime($appointedday->date)), array('id' => "date", 'class' => "form-control input-sm")) }}
		        			</div>
			        	</div>
			        	
			        	<div class="form-group">
			        		{{ Form::label('content', 'Ankündigung*:', array('class' => "col-md-2 control-label", 'id' => "content")) }}
			        		<div class="col-md-10">
			        			{{ Form::textarea('content', $appointedday->content, array('id' => "content", 'placeholder' => 'Ankündigungstext', 'class' => "form-control input-sm", 'rows'=>10, 'style' => 'resize:none;')) }}
			        		</div>
			        	</div>
			        	
			        	<div class="form-group">
		      				<div class="col-md-10 col-lg-offset-2" style="text-align: right">
								{{ Form::button('<i class="glyphicon glyphicon-refresh"></i> Aktualisieren', array('type' => 'submit', 'class' => 'btn btn-sm btn-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Informationen aktualisieren')) }}
		      				</div>
		      			</div>
		      		{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
@stop