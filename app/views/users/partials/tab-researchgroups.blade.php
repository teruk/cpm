<div class="row">
	<div class="col-sm-8">
		<div class="panel panel-primary">
            
            <div class="panel-body">
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
								<td colspan=3>Diesem Benutzer sind keine Arbeitsbereiche zugeordnet.</td>
							</tr>
						@else
							@foreach($user->researchgroups as $researchgroup)
								<tr>
									<td>{{ $researchgroup->name }}</td>
									<td>{{ $researchgroup->short }}</td>
									<td>
										@if (Entrust::can('detach_user_researchgroup') || Entrust::hasRole('Admin'))
												{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('detachResearchgroupUser_path', $user->id))) }}
												{{ Form::hidden('researchgroup_id', $researchgroup->id) }}
												{{ Form::hidden('tabindex', "researchgroups") }}
												{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-danger', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Zuordnung löschen')) }}
												{{ Form::close() }}
										@endif
									</td>
								</tr>
							@endforeach
						@endif
					</tbody>
					@if(Entrust::can('attach_user_researchgroup') || Entrust::hasRole('Admin'))
						<tfoot>
							<tr>
								<th colspan="3">Arbeitsbereich zuordnen:</th>
							</tr>
							<tr>
								{{ Form::model($user, ['method' => 'PATCH', 'route' => ['attachResearchgroupUser_path', $user->id]]) }}
								<td>{{ Form::select('researchgroup_id', $available_researchgroups, null, array('class' => 'form-control input-sm')) }} </td>
								<td></td>
								<td>
									{{ Form::button('<i class="glyphicon glyphicon-plus"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-success', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Arbeitsbereich zuordnen')) }}
									{{ Form::hidden('tabindex', "researchgroups") }}
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