@extends('layouts.main')

@include('users.partials.breadcrumb', ['breadcrumbTitle' => 'Arbeitsbereiche zuordnen'])

@section('main')
	
	<div class="row">
		@include('users.partials.sidenav')

		<div class="col-md-9">
			@include('users.partials.heading', ['title' => 'Arbeitsbereiche zuordnen:'])

			<p>Bearbeitung der Informationen dieses Benutzers.</p>
			<div class="panel panel-default">
	            <div class="panel-body">
	            	<div class="table-responsive">
	            		<table class="table table-striped table-condensed">
		            		<thead>
		            			<tr>
		            				<th>Arbeitsbereich</th>
		            				<th>Kurz</th>
		            				<th>Option</th>
		            			</tr>
		            		</thead>
		            		<tbody>	
				            	@if ( !$user->researchgroups->count() )
				            		<tr>
										<td colspan="3">Diesem Benutzer sind keine Arbeitsbereiche zugeordnet.</td>
									</tr>
								@else
									@foreach($user->researchgroups as $researchgroup)
										<tr>
											<td>{{ $researchgroup->name }}</td>
											<td>{{ $researchgroup->short }}</td>
											<td>
												@if ($currentUser->can('detach_user_researchgroup') || $currentUser->hasRole('Admin'))
														{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('detachResearchgroupUser_path', $user->id))) }}
														{{ Form::hidden('researchgroup_id', $researchgroup->id) }}
														{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-danger', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Zuordnung löschen')) }}
														{{ Form::close() }}
												@endif
											</td>
										</tr>
									@endforeach
								@endif
							</tbody>
							@if($currentUser->can('attach_user_researchgroup') || $currentUser->hasRole('Admin'))
								<tfoot>
									<tr>
										<th colspan="3">Arbeitsbereich zuordnen:</th>
									</tr>
									<tr>
										{{ Form::model($user, ['method' => 'PATCH', 'route' => ['attachResearchgroupUser_path', $user->id]]) }}
										<td>{{ Form::select('researchgroup_id', $availableResearchgroups, null, array('class' => 'form-control input-sm')) }} </td>
										<td></td>
										<td>
											{{ Form::button('<i class="glyphicon glyphicon-plus"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-success', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Arbeitsbereich zuordnen')) }}
											{{ Form::close() }}
										</td>
									</tr>
								</tfoot>
							@endif
						</table>
	            	</div>
				</div>
			</div>
		</div>
	</div>
@stop