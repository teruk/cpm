@extends('layouts.main')

@include('degreecourses.partials.breadcrumb', ['breadcrumbTitle' => 'Zugeordnete Module'])

@section('main')
	
	<div class="row">
		@include('degreecourses.partials.sidenav')

		<div class="col-md-9">
			@include('degreecourses.partials.heading', ['title' => 'Zugeordnete Module:'])

			<p>Die Zuordnungen der Module werden nach den FSB angezeigt.</p>
			<!-- <div class="table-responsive">
		        <table class="table table-striped table-condensed table-hover" cellspacing="0">
		        	<thead>
		                <tr>
		                  <th>FS</th>
		                  <th>Bereich</th>
		                  <th>Kürzel</th>
		                  <th>Titel</th>
		                  <th>LP</th>
		                  <th>Turnus</th>
		                </tr>
		          	</thead>
		          	<tbody>
						@foreach( $degreecourse->modules as $module )
							@if($listofsections[$module->pivot->section] != "Pflicht")
								@if($listofsections[$module->pivot->section] != "Wahlpflicht")
									<tr class="warning">
								@else
									<tr class="success">
								@endif
							@else
								<tr class="info">
							@endif
								<td>{{ $module->pivot->semester }}</td>
								<td>{{ $listofsections[$module->pivot->section] }}</td>
								<td>{{ $module->short }}</td>
								<td>
									@if ($currentUser->hasRole('Admin') OR $currentUser->can('edit_module'))
										{{ link_to_route('editModuleInformation_path', $module->name, $module->id) }}
									@else
										{{ $module->name }}
									@endif
								</td>
								<td>{{ $module->credits }}</td>
								<td>{{ $listofrotations[$module->rotation_id] }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div> -->

			@if ($degreecourse->specialistregulations->count() == 0)
				<p><i>Für diesen Studiengang existieren noch keine Fachspezifischen Bestimmungen. Bitte legen Sie diese zuerst {{link_to_route('editDegreecourseSpecialistregulations_path', 'hier', $degreecourse->id)}} an.</i></p>
			@else

				<ul class="nav nav-tabs">
					@for ($i = 0; $i < $degreecourse->specialistregulations->count(); $i++)
						@if ($i == 0)
							<li class="active">
						@else
							<li>
						@endif
						
						<a href="#{{ $specialistregulations[$i]->id }}" data-toggle="tab" aria-expanded="true">Ab {{ $specialistregulations[$i]->turn->present() }}</a></li>
					@endfor
				</ul>

				<div id="myTabContent" class="tab-content">
					@for ($i = 0; $i < $degreecourse->specialistregulations->count(); $i++)
						@if ($i == 0)
							<div class="tab-pane fade active in" id="{{ $specialistregulations[$i]->id }}">
						@else
							<div class="tab-pane fade" id="{{ $specialistregulations[$i]->id }}">
						@endif
							<div class="table-responsive">
						        <table class="table table-striped table-condensed table-hover" cellspacing="0">
						        	<thead>
						                <tr>
						                  <th>FS</th>
						                  <th>Bereich</th>
						                  <th>Kürzel</th>
						                  <th>Titel</th>
						                  <th>LP</th>
						                  <th>Turnus</th>
						                </tr>
						          	</thead>
						          	<tbody>
										@foreach( $specialistregulations[$i]->modules as $module )
											@if($listofsections[$module->pivot->section] != "Pflicht")
												@if($listofsections[$module->pivot->section] != "Wahlpflicht")
													<tr class="warning">
												@else
													<tr class="success">
												@endif
											@else
												<tr class="info">
											@endif
												<td>{{ $module->pivot->semester }}</td>
												<td>{{ $listofsections[$module->pivot->section] }}</td>
												<td>{{ $module->short }}</td>
												<td>
													@if ($currentUser->hasRole('Admin') OR $currentUser->can('edit_module'))
														{{ link_to_route('editModuleInformation_path', $module->name, $module->id) }}
													@else
														{{ $module->name }}
													@endif
												</td>
												<td>{{ $module->credits }}</td>
												<td>{{ $listofrotations[$module->rotation_id] }}</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					@endfor
				</div>
			@endif
		</div>
	</div>
@stop