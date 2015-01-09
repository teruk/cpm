<div class="row">
	<div class="col-sm-7">
		<div class="panel panel-primary">
            <div class="panel-body">
				<div class="btn-toolbar" style="margin-bottom: 5px;">
					@if (Entrust::hasRole('Admin') || Entrust::can('edit_mediumtermplanning'))
						<div class="btn-group">
						    <a href="#" class="btn btn-success btn-xs" id="btn-addMediumtermplanning" data-toggle="tooltip" data-placement="top" data-original-title="Mittelfristige Lehrplanung anlegen"><i class="glyphicon glyphicon-plus"></i> MLP hinzufügen</a>
					  	</div>

					  	@if (sizeof($module->mediumtermplannings) > 0)
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
								<td>{{ $m->turn->name }} {{ $m->turn->year }}</td>
								<td>
									@foreach ($m->employees as $e)
										@if ($e->pivot->annulled)
											<p><s>{{ $e->firstname }} {{ $e->name }} ({{ $e->pivot->semester_periods_per_week }} SWS)</s></p>
										@else
											<p>{{ $e->firstname }} {{ $e->name }} ({{ $e->pivot->semester_periods_per_week }} SWS)</p>
										@endif
									@endforeach
								</td>
								<!-- <td>
									@if (sizeof($m->employees) > 0)
										{{ Form::model($module, ['method' => 'POST', 'route' => ['modules.copyMediumtermplanning', $module->id, $m->id], 'class' => "form-horizontal"]) }}
										{{ Form::button('<i class="glyphicon glyphicon-repeat"></i>', array('type' => 'button', 'class' => 'btn btn-xs btn-info', 'data-toggle' => 'modal', 'data-target' => '#copymediumtermplanning', 'data-original-title' => 'Mittelfristige Lehrplanung kopieren')) }}
										{{ Form::hidden('tabindex', "mediumtermplanning") }}
										{{ Form::close() }}
									@endif
									</td> -->
									<td>
										{{ HTML::decode(link_to_route('editMediumtermplanning_path', '<i class="glyphicon glyphicon-edit"></i>', array($module->id, $m->id), array('class' => 'btn btn-xs btn-warning', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Mittelfristige Lehrplanung bearbeiten'))) }}
									</td>
									<td>	
										{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('deleteMediumtermplanning_path', $module->id, $m->id))) }}
										{{ Form::hidden('tabindex', "mediumtermplanning") }}
										{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'button', 'class' => 'btn btn-xs btn-danger','data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Mittelfristige Lehrplanung löschen', 'data-message' => 'Wollen Sie die Mittelfristige Lehrplanung für dieses Semester wirklich löschen?')) }}
										{{ Form::close() }}
									</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>