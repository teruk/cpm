@extends('layouts.main')

@include('employees.partials.breadcrumb', ['breadcrumbTitle' => 'Informationen bearbeiten'])

@section('main')
	
	<div class="row">
		@include('employees.partials.sidenav')

		<div class="col-md-9">
			@include('employees.partials.heading', ['title' => 'Informationen bearbeiten:'])

			<p>Informationen des Mitarbeiters bearbeiten.</p>
			<div class="panel panel-default">
			    <div class="panel-body">
					{{ Form::model($employee, ['method' => 'PATCH', 'route' => ['updateEmployee_path', $employee->id], 'class' => "form-horizontal"]) }}
					
	        			<div class="form-group">
		    				{{ Form::label('title', 'Titel:', array('class' => "col-md-2 control-label", 'id' => "title")) }}
		    				<div class="col-md-10">
		    					{{ Form::input('text', 'title', $employee->title, array('id' => "title", 'min' => 3, 'placeholder' => 'z.B. Prof.', 'class' => "form-control input-sm")) }}
		    				</div>
	        			</div>

	        			<div class="form-group">
	        				{{ Form::label('firstname', 'Vorname*:', array('class' => "col-md-2 control-label", 'id' => "firstname")) }}
	        				<div class="col-md-10">
	        					{{ Form::input('text', 'firstname', $employee->firstname, array('id' => "firstname", 'min' => 2, 'placeholder' => 'Vorname', 'required' => true, 'class' => "form-control input-sm")) }}
	        				</div>
		        		</div>

		        		<div class="form-group">
	        				{{ Form::label('name', 'Nachname*:', array('class' => "col-md-2 control-label", 'id' => "name")) }}
	        				<div class="col-md-10">
        						{{ Form::input('text', 'name', $employee->name, array('id' => "name", 'min' => 2, 'placeholder' => 'Nachname', 'required' => true, 'class' => "form-control input-sm")) }}
	        				</div>
		        		</div>

		        		<div class="form-group">
	        				{{ Form::label('researchgroup_id', 'Arbeitsbereich*:', array('class' => "col-md-2 control-label", 'id' => "researchgroup_id")) }}
	        				<div class="col-md-10">
	        						{{ Form::select('researchgroup_id', $researchgroups, $employee->researchgroup_id, array('id' => "researchgroup_id", 'class' => "form-control input-sm")) }}
	        				</div>
	        			</div>
        			
	        			<div class="form-group">
	        				{{ Form::label('employed_since', 'Angestellt seit:*:', array('class' => "col-md-2 control-label", 'id' => "employed_since")) }}
	        				<div class="col-md-4">
	        					{{ Form::input('date', 'employed_since', date('Y-m-d', strtotime($employee->employed_since)), array('id' => "employed_since", 'class' => "form-control input-sm", 'required' => true)) }}
	        				</div>
	        			
	        				{{ Form::label('employed_till', 'Angestellt bis:*:', array('class' => "col-md-2 control-label", 'id' => "employed_till")) }}
	        				<div class="col-md-4">
	        					{{ Form::input('date', 'employed_till', date('Y-m-d', strtotime($employee->employed_till)), array('id' => "employed_till", 'class' => "form-control input-sm", 'required' => true)) }}
	        				</div>
	        			</div>

	        			<div class="form-group">
	        				{{ Form::label('teaching_load', 'Lehrdeputat (SWS):*:', array('class' => "col-md-2 control-label", 'id' => "teaching_load")) }}
	        				<div class="col-md-4">
	        					{{ Form::input('number', 'teaching_load', $employee->teaching_load, array('min' => 0, 'id' => "teaching_load", 'class' => "form-control input-sm", 'required' => true)) }}
	        				</div>
	        			
	        				{{ Form::label('inactive', 'Ehemalig:', array('class' => "col-md-2 control-label", 'id' => "inactive")) }}
	        				<div class="col-md-4">
	        					{{ Form::checkbox('inactive', 1, $employee->inactive, array('id' => "inactive", 'class' => "form-control input-sm")) }}
	        				</div>
	        			</div>
        			
	        			<div class="form-group">
	      					<div class="col-lg-10 col-lg-offset-2" style="text-align: right">
	      					@if (Entrust::hasRole('Admin') || Entrust::can('edit_employee'))
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