@extends('layouts.main')

@section('scripts')
	<script type="text/javascript" class="init">

	    $(document).ready(function() {

			$('#btn-copyMediumtermplanning').click(function () {
			     $('#copymediumtermplanning').modal('show');
			});

			$('#btn-addMediumtermplanning').click(function () {
			     $('#addmediumtermplanning').modal('show');
			});

	    } );

	</script>

	@include('layouts.partials.delete-confirm-js')
@stop

@include('modules.partials.breadcrumb', ['breadcrumbTitle' => 'Mittelfristige Lehrplannung'])

@section('main')
	
	<div class="row">
		@include('modules.partials.sidenav')

		<div class="col-md-9">
			@include('modules.partials.heading', ['title' => 'Mittelfristige Lehrplanung:'])

			<p>Bearbeiten der mittelfristigen Lehrplanung für dieses Modul.</p>
			<div class="btn-toolbar" style="margin-bottom: 5px;">
				@if ($currentUser->hasRole('Admin') || $currentUser->can('add_mediumtermplanning'))

					<div class="btn-group">
					    <a href="#" class="btn btn-success btn-xs" id="btn-addMediumtermplanning" data-toggle="tooltip" data-placement="top" data-original-title="Mittelfristige Lehrplanung anlegen"><i class="glyphicon glyphicon-plus"></i> MLP hinzufügen</a>
				  	</div>

				  	@if ($module->mediumtermplannings->count() > 0)
					  	<div class="btn-group">
						    <a href="#" class="btn btn-copy btn-xs" id="btn-copyMediumtermplanning" data-toggle="tooltip" data-toggle="tooltip" data-placement="top" data-original-title="Mittelfristige Lehrplanung kopieren"><i class="glyphicon glyphicon-repeat"></i> MLP kopieren</a>
					  	</div>
					@endif
					
				@endif
			</div>
			<table class="table table-striped table-condensed">
				<thead>
					<tr>
						<th>Semester</th>
						<th>Verantwortliche</th>
						<th colspan="2"  width="10%">Optionen</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($mtp as $m)
						<tr>
							<td>{{ $m->turn->present() }}</td>
							<td>
								@foreach ($m->employees as $e)
									@if ($e->pivot->annulled)
										<p><s>{{ $e->firstname }} {{ $e->name }} ({{ $e->pivot->semester_periods_per_week }} SWS)</s></p>
									@else
										<p>{{ $e->firstname }} {{ $e->name }} ({{ $e->pivot->semester_periods_per_week }} SWS)</p>
									@endif
								@endforeach
							</td>
							<td>
								@if ($currentUser->hasRole('Admin') || $currentUser->can('edit_mediumtermplanning'))
									{{ HTML::decode(link_to_route('editMediumtermplanning_path', '<i class="glyphicon glyphicon-edit"></i>', array($module->id, $m->id), array('class' => 'btn btn-xs btn-warning', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Mittelfristige Lehrplanung bearbeiten'))) }}
								@endif
							</td>
							<td>
								@if ($currentUser->hasRole('Admin') || $currentUser->can('delete_mediumtermplanning'))
									{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('deleteMediumtermplanning_path', $module->id, $m->id))) }}
									{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'button', 'class' => 'btn btn-xs btn-danger','data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Mittelfristige Lehrplanung löschen', 'data-message' => 'Wollen Sie die Mittelfristige Lehrplanung für dieses Semester wirklich löschen?')) }}
									{{ Form::close() }}
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

	<div class="modal fade" id="copymediumtermplanning" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  	@include('modules.partials.copy-mediumtermplanning-form')
	</div>

	<div class="modal fade" id="addmediumtermplanning" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  	@include('modules.partials.add-mediumtermplanning-form')
	</div>

	<!-- delete confirmation modal dialog -->
  	@include('layouts.partials.delete_confirm')
@stop