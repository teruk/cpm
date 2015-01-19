@extends('layouts.main')

@include('modules.partials.breadcrumb', ['breadcrumbTitle' => 'Zugeordnete Studiengänge'])

@section('main')
	
	<div class="row">
		@include('modules.partials.sidenav')

		<div class="col-md-9">
			@include('modules.partials.heading', ['title' => 'Zugeordnete Studiengänge:'])

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
				            	@if ( !$module->specialistregulations->count() )
				            		<tr>
										<td colspan="5"> Modul ist keinem Studiengang zugeordnet.</td>
									</tr>
								@else
									@foreach( $module->specialistregulations as $specialistregulation )
										<tr>
											{{ Form::open(array('class' => 'inline', 'method' => 'PATCH', 'route' => ['updateDegreecourseModule_path', $module->id, $specialistregulation->id])) }}
											<td>
												@if ($currentUser->hasRole('Admin') || $currentUser->can('edit_degreecourse'))
													{{ link_to_route('editDegreecourseInformation_path', $specialistregulation->present(), $specialistregulation->degreecourse_id) }}
												@else
													{{ $specialistregulation->present() }}
												@endif
											</td>
											<td>
												{{ Form::select('section', $sections, $specialistregulation->pivot->section, array('class' => 'form-control input-sm')) }}
											</td>
											<td>
												{{ Form::selectRange('semester', 1, 8, $specialistregulation->pivot->semester, array('class' => 'form-control input-sm')) }}
											</td>
											<td>
												{{ Form::button('<i class="glyphicon glyphicon-refresh"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Zuordnung aktualisieren')) }}
											</td>
												{{ Form::close() }}
											<td>
												{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => ['detachDegreecourseModule_path', $module->id, $specialistregulation->id])) }}
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
									<td>{{ Form::select('specialistregulationId', $specialistregulations, '', array('class' => 'form-control input-sm')) }} </td>
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