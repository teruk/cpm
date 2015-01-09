@extends('layouts.main')

@include('degrees.partials.breadcrumb', ['breadcrumbTitle' => 'Informationen bearbeiten'])

@section('main')
	
	<div class="row">
		@include('degrees.partials.sidenav')

		<div class="col-md-9">
			@include('degrees.partials.heading', ['title' => 'Informationen bearbeiten:'])

			<p>Bearbeitung der Informationen dieses Abschlusses.</p>

			<div class="panel panel-default">
		       	<div class="panel-body">
		       		{{ Form::model($degree, ['method' => 'PATCH', 'route' => ['updateDegree_path', $degree->id], 'class' => "form-horizontal"]) }}

		       		<div class="form-group">
		       			{{ Form::label('name', 'Name*:', ['class' => 'col-md-2 control-label']) }}
		       			<div class="col-md-10">
		       				{{ Form::text('name', $degree->name, array('class' => 'form-control input-sm')) }}
		       			</div>
		       		</div>

		       		<div class="form-group">
		       			<div class="col-md-10 col-lg-offset-2" style="text-align: right">
	      					@if (Entrust::hasRole('Admin') || Entrust::can('edit_degree'))
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