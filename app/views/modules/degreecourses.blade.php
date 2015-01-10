@extends('layouts.main')

@include('modules.partials.breadcrumb', ['breadcrumbTitle' => 'Zugehörige Lehrveranstaltungen'])

@section('main')
	
	<div class="row">
		@include('modules.partials.sidenav')

		<div class="col-md-9">
			@include('modules.partials.heading', ['title' => 'Zugehörige Lehrveranstaltungen:'])

			<p>Bearbeiten der Modulzugehörigkeit zu Studiengängen.</p>
			<div class="panel panel-default">
	            <div class="panel-body">
	            	<div class="table-responsive">
	            		<table class="table table-striped table-condensed">
		            		<thead>
		            			<tr>
		            				<th>Abschluss Name</th>
		            				<th>Bereich</th>
		            				<th>FS</th>
		            				<th colspan="2">Option</th>
		            			</tr>
		            		</thead>
		            		<tbody>	
				            	@if ( !$module->degreecourses->count() )
				            		<tr>
										<td colspan="5"> Modul ist keinem Studiengang zugeordnet.</td>
									</tr>
								@else
									@foreach( $module->degreecourses as $degreecourse )
										<tr>
											{{ Form::open(array('class' => 'inline', 'method' => 'PATCH', 'route' => array('updateDegreecourseModule_path', $module->id))) }}
											<td>
												@if ($currentUser->hasRole('Admin') || $currentUser->can('edit_degreecourse'))
													{{ link_to_route('editDegreecourseInformation_path', $degreecourse->present(), $degreecourse->id) }}
												@else
													{{ $degreecourse->present() }}
												@endif
											</td>
											<td>
												{{ Form::select('section', $sections, $degreecourse->pivot->section, array('class' => 'form-control input-sm')) }}
											</td>
											<td>
												{{ Form::selectRange('semester', 1, 8, $degreecourse->pivot->semester, array('class' => 'form-control input-sm')) }}
											</td>
												{{ Form::hidden('degreecourse_id', $degreecourse->id) }}
											<td>
												{{ Form::button('<i class="glyphicon glyphicon-refresh"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Zuordnung aktualisieren')) }}
											</td>
												{{ Form::close() }}
											<td>
												{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('detachDegreecourseModule_path', $module->id))) }}
												{{ Form::hidden('degreecourse_id', $degreecourse->id) }}
												{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'button', 'class' => 'btn btn-xs btn-danger', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'title' => 'Zuordnung löschen', 'data-message' => 'Wollen Sie die Zuodnung wirklich löschen?')) }}
												{{ Form::close() }}
											</td>
										</tr>
									@endforeach
								@endif
							{{ Form::model($module, ['method' => 'PATCH', 'route' => ['attachDegreecourseModule_path', $module->id]]) }}
							</tbody>
							<tfoot>
								<tr>
									<th colspan="5">Studiengang zuordnen:</th>
								</tr>
								<tr>
									<td>{{ Form::select('id', $degreecourses, '', array('class' => 'form-control input-sm')) }} </td>
									<td>{{ Form::select('section', $sections, 0, array('class' => 'form-control input-sm'))}}</td>
									<td>{{ Form::selectRange('semester', 1, 8, 1, array('class' => 'form-control input-sm')) }}</td>
									<td colspan=2>{{ Form::button('<i class="glyphicon glyphicon-arrow-right"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-success', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Studiengang zuordnen')) }}</td>
								</tr>
								{{ Form::close() }}
							</tfoot>
						</table>
	            	</div>
				</div>
			</div>
		</div>
	</div>

	<!-- delete confirmation modal dialog -->
  	@include('layouts.partials.delete_confirm')
@stop