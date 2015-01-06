<div class="panel-group" id="lecturer_accordion">
	@if (sizeof($oldplannings) > 0)
		  <div class="panel panel-default">
		    <div class="panel-heading">
		      <h4 class="panel-title">
		        <a data-toggle="collapse" data-parent="#lecturer_accordion" href="#collapseOneCourse">
		        	Veranstaltungen der vergangenen Semester:
		        </a>
		      </h4>
		    </div>
		    <div id="collapseOneCourse" class="panel-collapse collapse">
		      <div class="panel-body">
					<table class="table table-striped table-condensed">
						<thead>
							<tr>
								<th>Semester</th>
								<th>Nummer</th>
								<th>Modul</th>
								<th>Typ</th>
								<th>Bemerkung</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach($oldplannings as $p)								
								<tr>
									<td>{{ $p->turn->name }} {{$p->turn->year}}</td>
									<td>{{ $p->course_number }}</td>
									<td>{{ $p->course->module->short }}</td>
									<td>{{ $p->course->coursetype->short }}</td>
									<td>{{ $p->comment }}</td>
									<td>{{ HTML::decode(link_to_route('editPlanningInformation_path', '<i class="glyphicon glyphicon-edit"></i>', [$p->turn_id, $p->id], ['class' => 'btn btn-xs btn-warning', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Zur Veranstaltung wechseln'])) }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
		      </div>
		    </div>
		  </div>
	@endif
	@if (sizeof($relatedplannings) > 0)
		<div class="panel panel-default">
		    <div class="panel-heading" role="tab" id="headingTwo">
		      <h4 class="panel-title">
		        <a data-toggle="collapse" data-parent="#lecturer_accordion" href="#collapseTwoCourse" aria-expanded="true" aria-controls="collapseTwo">
		          Dazugehörige Veranstaltungen:
		        </a>
		      </h4>
		    </div>
		    <div id="collapseTwoCourse" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
		    	<div class="panel-body">
		    		<table class="table table-striped table-condensed">
						<thead>
							<tr>
								<th>Nummer</th>
								<th>Modul</th>
								<th>Typ</th>
								<th>Grp.</th>
								<th>Bemerkung</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach($relatedplannings as $p)								
								<tr>
									<td>{{ $p->course_number }}</td>
									<td>{{ $p->course->module->short }}</td>
									<td>{{ $p->course->coursetype->short }}</td>
									<td>{{ $p->group_number }}</td>
									<td>{{ $p->comment }}</td>
									<td>{{ HTML::decode(link_to_route('editPlanningInformation_path', '<i class="glyphicon glyphicon-edit"></i>', [$turn->id, $p->id], ['class' => 'btn btn-xs btn-warning', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Zur Veranstaltung wechseln'])) }}</td>
								</tr>
							@endforeach
						</tbody>
						<tfoot><tr><td colspan=7></td></tr></tfoot>
					</table>
	      		</div>
	    	</div>
	  	</div>
	@endif
</div>