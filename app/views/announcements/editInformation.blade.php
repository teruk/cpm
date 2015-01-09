@extends('layouts.main')

@include('announcements.partials.breadcrumb', ['breadcrumbTitle' => 'Informationen bearbeiten'])

@section('main')
	
	<div class="row">
		@include('announcements.partials.sidenav')

		<div class="col-md-9">
			@include('announcements.partials.heading', ['title' => 'Information bearbeiten:'])

			<p>Hier kann die ausgewählte Ankündigung bearbeitet werden.</p>

			<div class="panel panel-default">
		        <div class="panel-body">
					{{ Form::model($announcement, ['method' => 'PATCH', 'route' => ['updateAnnouncement_path', $announcement->id], 'class' => "form-horizontal"]) }}
			           	<div class="form-group">
		        			{{ Form::label('subject', 'Betreff*:', array('class' => "col-lg-2", 'id' => "subject")) }}
		        			<div class="col-lg-10">
		        				{{ Form::input('text', 'subject', $announcement->subject, array('id' => "subject", 'min' => 3, 'placeholder' => 'Betreff', 'required' => true, 'class' => "form-control input-sm")) }}
		        			</div>
			        	</div>
			        	
			        	<div class="form-group">
			        		{{ Form::label('content', 'Ankündigung*:', array('class' => "col-lg-2", 'id' => "content")) }}
			        		<div class="col-lg-10">
			        			{{ Form::textarea('content', $announcement->content, array('id' => "content", 'placeholder' => 'Ankündigungstext', 'class' => "form-control input-sm", 'rows'=>10, 'style' => 'resize:none;', 'required')) }}
			        		</div>
			        	</div>
			        	
			        	@if ($currentUser->hasRole('Admin') OR $currentUser->can('edit_announcement'))
				        	<div class="form-group">
			      				<div class="col-lg-10 col-lg-offset-2" style="text-align: right">
									{{ Form::button('<i class="glyphicon glyphicon-refresh"></i> Aktualisieren', array('type' => 'submit', 'class' => 'btn btn-sm btn-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Informationen aktualisieren')) }}
			      				</div>
			      			</div>
			      		@endif
		      		{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
@stop