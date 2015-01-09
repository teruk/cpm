@extends('layouts.main')

@include('departments.partials.breadcrumb', ['breadcrumbTitle' => 'Informationen bearbeiten'])

@section('main')
	
	<div class="row">
		@include('departments.partials.sidenav')

		<div class="col-md-9">
			@include('departments.partials.heading', ['title' => 'Informationen bearbeiten:'])

			<p>Bearbeitung der Informationen dieses Studiengangs.</p>

			<div class="panel panel-default">
		        <div class="panel-body">
					{{ Form::model($department, ['method' => 'PATCH', 'route' => ['updateDepartment_path', $department->id], 'class' => 'form-horizontal']) }}

						<div class="form-group">
							{{ Form::label('short', 'Kürzel*:', array('class' => "col-md-2 control-label", 'id' => "short")) }}
							<div class="col-md-10">
								{{ Form::input('text', 'short', $department->short, array('id' => "short", 'min' => 2, 'placeholder' => 'Kürzel','required'=>true, 'class' => 'form-control input-sm')) }}
							</div>
						
							{{ Form::label('name', 'Titel*:', ['class' => 'col-md-2 control-label']) }}
							<div class="col-md-10">
								{{ Form::text('name', $department->name, ['required' => true, 'placeholder' => 'Name', 'class' => 'form-control input-sm' , 'id' => 'name']) }}
							</div>
						</div>

						<div class="form-group">
	      					<div class="col-md-10 col-lg-offset-2" style="text-align: right">
	      					@if (Entrust::hasRole('Admin') || Entrust::can('edit_department'))
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