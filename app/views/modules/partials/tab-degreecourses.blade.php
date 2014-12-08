<div class="row">
	<div class="col-sm-8">
		<div class="panel panel-primary">
            
            <div class="panel-body ui-widget">
            	<table class="table table-striped table-condensed">
            		<thead>
            			<tr>
            				<th>Abschluss Name</th>
            				<th>Bereich</th>
            				<th>FS</th>
            				<th colspan=2>Option</th>
            			</tr>
            		</thead>
            		<tbody>	
		            	@if ( !$module->degreecourses->count() )
		            		<tr>
								<td colspan=4> Modul ist keinem Studiengang zugeordnet.</td>
							</tr>
						@else
							@foreach( $module->degreecourses as $degreecourse )
								<tr>
									<td> 
										<a href="{{ route('degree_courses.show', [$degreecourse->id]) }}">{{ $lists['degrees'][$degreecourse->degree_id] }} {{ $degreecourse->name }}</a>
									</td>
									{{ Form::open(array('class' => 'inline', 'method' => 'PATCH', 'route' => array('modules.updateDegreecourse', $module->id))) }}
									<td>{{ Form::select('section', $lists['sections'], $degreecourse->pivot->section, array('class' => 'form-control input-sm')) }}</td>
									<td>{{ Form::selectRange('semester', 1, 8, $degreecourse->pivot->semester, array('class' => 'form-control input-sm')) }}</td>
									{{ Form::hidden('degreecourse_id', $degreecourse->id) }}
									{{ Form::hidden('tabindex', "degreecourses") }}
									<td>{{ Form::button('<i class="glyphicon glyphicon-refresh"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Zuordnung aktualisieren')) }}</td>
									{{ Form::close() }}
									<td>
										{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('modules.detach', $module->id))) }}
										{{ Form::hidden('degree_course_id', $degreecourse->id) }}
										{{ Form::hidden('tabindex', "degreecourses") }}
										{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'button', 'class' => 'btn btn-xs btn-danger', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'title' => 'Zuordnung löschen', 'data-message' => 'Wollen Sie die Zuodnung wirklich löschen?')) }}
										{{ Form::close() }}
									</td>
								</tr>
							@endforeach
						@endif
					{{ Form::model($module, ['method' => 'PATCH', 'route' => ['modules.attach', $module->id]]) }}
					</tbody>
					<tfoot>
						<tr>
							<th colspan="5">Studiengang zuordnen:</th>
						</tr>
						<tr>
							<td>{{ Form::select('id', $lists['degreecourses'], '', array('class' => 'form-control input-sm')) }} </td>
							<td>{{ Form::select('section', $lists['sections'], 0, array('class' => 'form-control input-sm'))}}</td>
							<td>{{ Form::selectRange('semester', 1, 8, 1, array('class' => 'form-control input-sm')) }}</td>
							<td colspan=2>{{ Form::button('<i class="glyphicon glyphicon-arrow-right"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-success', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Studiengang zuordnen')) }}</td>
							{{ Form::hidden('tabindex', "degreecourses") }}
						</tr>
						{{ Form::close() }}
					</tfoot>
				</table>
			</div>
		</div>
	</div>        	
</div>