@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li><a href="{{ URL::route('showTurnPlannings_path', $turn->id)}}">Semesterplanung</a></li>
	  <li><a href="{{ URL::route('showTurnPlannings_path', $turn->id)}}">{{ $turn->present() }}</a></li>
	  <li class="active">{{$course->module->short}} {{ $course->module->name }}</li>
	  <li class="active">Modulabschluss bearbeiten</li>
	</ol>
@stop

@section('main')
	

	<div class="row">
		@include('plannings.partials.sidenav', ['showEmployees' => true, 'showRooms' => true, 'showInformation' => true])

		<div class="col-md-9">
			@include('plannings.partials.heading', ['title' => 'Modulabschluss bearbeiten:'])
			
			<p>
				[Infotext]
			</p>
			<div class="panel panel-default">
            	<div class="panel-body">
            		

            		{{ Form::model($planning, ['method' => 'PATCH', 'route' => ['updatePlanningExam_path',$turn->id, $planning->id], 'class' => "form-horizontal"])}}
		    		<fieldset>
		    			<div class="form-group">
		    				{{ Form::label('exam_type', 'Abschluss laut Modulhandbuch*:', array('class' => "col-lg-5", 'id' => "exam_type")) }}
		    				<div class="col-lg-7">
		    					{{ Config::get('constants.exam_type')[$course->module->exam_type] }}
		    				</div>
		    			</div>
		    			@if ($currentUser->hasRole('Admin') || $currentUser->can('update_planning_exam_type'))
			    			<div class="form-group">
			    				{{ Form::label('exam_type', 'Abschluss dieses Semester*:', array('class' => "col-lg-5", 'id' => "exam_type")) }}
			    				<div class="col-lg-7">
			    					{{ Form::select('exam_type', Config::get('constants.exam_type'), $exam->exam, array('id' => "exam_type", 'class' => "form-control input-sm")) }}
			    				</div>
			    			</div>
			    			<div class="form-group">
			  					<div class="col-lg-5 col-lg-offset-7" style="text-align: right">
								{{ Form::button('<i class="glyphicon glyphicon-refresh"></i> Aktualisieren', array('type' => 'submit', 'class' => 'btn btn-sm btn-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Modulabschluss aktualisieren')) }}
			  					</div>
			  				</div>
			  			@endif
					</fieldset>
					{{ Form::hidden('module_id', $course->module->id)}}
					{{ Form::close() }}

            	</div>
            </div>
		</div>
	</div>
@stop