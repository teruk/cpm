@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li><a href="{{ URL::to('announcements')}}">Ankündigungsmanagement</a></li>
	  <li class="active">{{ $announcement->subject }}</li>
	</ol>
@stop

@section('main')
	<div class="row">
		<div class="col-sm-8">
			<div class="panel panel-primary">
		        <div class="panel-body">
					{{ Form::model($announcement, ['method' => 'PATCH', 'route' => ['updateAnnouncement_path', $announcement->id], 'class' => "form-horizontal"]) }}
			        <fieldset>
			        	<legend>Ankündigung aktualisieren</legend>
			        	<div class="form-group">
		        			{{ Form::label('subject', 'Betreff*:', array('class' => "col-lg-3 control-label", 'id' => "subject")) }}
		        			<div class="col-lg-9">
		        				{{ Form::input('text', 'subject', $announcement->subject, array('id' => "subject", 'min' => 3, 'placeholder' => 'Betreff', 'required' => true, 'class' => "form-control input-sm")) }}
		        			</div>
			        	</div>
			        	
			        	<div class="form-group">
			        		{{ Form::label('content', 'Ankündigung*:', array('class' => "col-lg-3 control-label", 'id' => "content")) }}
			        		<div class="col-lg-9">
			        			{{ Form::textarea('content', $announcement->content, array('id' => "content", 'placeholder' => 'Ankündigungstext', 'class' => "form-control input-sm", 'rows'=>10, 'style' => 'resize:none;', 'required')) }}
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