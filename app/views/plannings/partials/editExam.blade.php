<div class="row">
	<div class="col-sm-6">
		<div class="panel panel-primary">
            <div class="panel-body">
            	{{ Form::model($planning, ['method' => 'PATCH', 'route' => ['plannings.updateExamType',$turn->id, $planning->id], 'class' => "form-horizontal"])}}
	    		<fieldset>
	    			<div class="form-group">
	    				{{ Form::label('exam_type', 'Abschluss laut Modulhandbuch*:', array('class' => "col-lg-7 control-label", 'id' => "exam_type")) }}
	    				<div class="col-lg-5">
	    					{{ Config::get('constants.exam_type')[$course->module->exam_type] }}
	    				</div>
	    			</div>
	    			@if ($currentUser->hasRole('Admin') || $currentUser->can('update_planning_exam_type'))
		    			<div class="form-group">
		    				{{ Form::label('exam_type', 'Abschluss dieses Semester*:', array('class' => "col-lg-7 control-label", 'id' => "exam_type")) }}
		    				<div class="col-lg-5">
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
				{{ Form::hidden('tabindex', 3)}}
				{{ Form::hidden('module_id', $course->module->id)}}
				{{ Form::close() }}
            </div>
        </div>
    </div>
</div>	