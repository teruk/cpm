@extends('layouts.main')

@include('degreecourses.partials.breadcrumb', ['breadcrumbTitle' => 'Informationen bearbeiten'])

@section('main')
	
	<div class="row">
		@include('degreecourses.partials.sidenav')

		<div class="col-md-9">
			@include('degreecourses.partials.heading', ['title' => 'Informationen bearbeiten:'])

			<p>Bearbeitung der Informationen dieses Studiengangs.</p>
			<div class="panel panel-default">
	            <div class="panel-body">
	            	{{ Form::model($degreecourse, ['method' => 'PATCH', 'route' => ['updateDegreecourse_path', $degreecourse->id], 'class' => "form-horizontal"]) }}
						<div class="form-group">
	        				{{ Form::label('short', 'Kürzel*:', array('class' => "col-md-2 control-label", 'id' => "short")) }}
	        				<div class="col-md-10">
	        					{{ Form::input('text', 'short', $degreecourse->short, array('id' => "short", 'min' => 2, 'placeholder' => 'Kürzel','required'=>true, 'class' => 'form-control input-sm')) }}
	        				</div>
		        		</div>

		        		<div class="form-group">
	        				{{ Form::label('name', 'Name*:', array('class' => "col-md-2 control-label", 'id' => "name")) }}
	        				<div class="col-md-10">
	        					{{ Form::input('text', 'name', $degreecourse->name, array('id' => "name", 'min' => 2, 'placeholder' => 'Name','required'=>true, 'class' => 'form-control input-sm')) }}
	        				</div>
		        		</div>

		        		<div class="form-group">
	        				{{ Form::label('degree_id', 'Abschluss*:', array('class' => "col-md-2 control-label", 'id' => "degree_id")) }}
	        				<div class="col-md-4">
	        					{{ Form::select('degree_id', $listofdegrees, $degreecourse->degree_id, array('id' => "degree_id",  'class' => 'form-control input-sm')) }}
	        				</div>
	        				{{ Form::label('department_id', 'Fachbereich*:', array('class' => "col-md-2 control-label", 'id' => "department_id")) }}
	        				<div class="col-md-4">
	        					{{ Form::select('department_id', $listofdepartments, $degreecourse->department_id, array('id' => "department_id",  'class' => 'form-control input-sm')) }}
	        				</div>
		        		</div>

		        		<div class="form-group">
	      					<div class="col-md-10 col-lg-offset-2" style="text-align: right">
	      					@if (Entrust::hasRole('Admin') || Entrust::can('edit_degreecourse'))
		      					*erforderlich
		      					{{ Form::button('<i class="glyphicon glyphicon-refresh"></i> Aktualisieren', array('type' => 'submit', 'class' => 'btn btn-sm btn-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Informationen aktualisieren')) }}
		      				@endif
	      					</div>
	      				</div>
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
@stop