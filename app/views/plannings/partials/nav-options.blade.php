<div class="col-sm-12" style="margin-bottom: 5px;">
	<div class="btn-toolbar">
		@if ($currentUser->hasRole('Admin') || $currentUser->can('add_planning'))
			<div class="btn-group">
			    <div class="btn-group btn-success">
			      	<a href="#" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown">
				        <i class="glyphicon glyphicon-plus"></i> Modul planen
				        <span class="caret"></span>
			      	</a>
			      	<ul class="dropdown-menu">
				        <li><a href="#planningBacModule" data-toggle="modal" data-target="#planningBacModule"><i class="glyphicon glyphicon-plus"></i> Bachelor Modul</a></li>
				        <li><a href="#planningMaModule" data-toggle="modal" data-target="#planningMaModule"><i class="glyphicon glyphicon-plus"></i> Master Modul</a></li>
			       	</ul>
			    </div>
		  	</div>
		@endif

		@if ($currentUser->hasRole('Admin') || $currentUser->can('add_planning'))
			<div class="btn-group">
			    <div class="btn-group btn-success">
			      <a href="#" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown">
			        <i class="glyphicon glyphicon-plus"></i> LV planen
			        <span class="caret"></span>
			      </a>
			      <ul class="dropdown-menu">
			        <li><a href="#planningLecture" data-toggle="modal" data-target="#planningLecture"><i class="glyphicon glyphicon-plus"></i> Vorlesung</a></li>
			        <li><a href="#planningExercise" data-toggle="modal" data-target="#planningExercise"><i class="glyphicon glyphicon-plus"></i> Übung</a></li>
			        <li><a href="#planningProseminar" data-toggle="modal" data-target="#planningProseminar"><i class="glyphicon glyphicon-plus"></i> Proseminar</a></li>
			        <li><a href="#planningSeminar" data-toggle="modal" data-target="#planningSeminar"><i class="glyphicon glyphicon-plus"></i> Seminar</a></li>
			        <li><a href="#planningPracticalCourse" data-toggle="modal" data-target="#planningPracticalCourse"><i class="glyphicon glyphicon-plus"></i> Praktikum</a></li>
			        <li><a href="#planningProject" data-toggle="modal" data-target="#planningProject"><i class="glyphicon glyphicon-plus"></i> Projekt</a></li>
			        <li><a href="#planningIntegratedSeminar" data-toggle="modal" data-target="#planningIntegratedSeminar"><i class="glyphicon glyphicon-plus"></i> Integriertes Seminar</a></li>
			        <li><a href="#planningOther" data-toggle="modal" data-target="#planningOther"><i class="glyphicon glyphicon-plus"></i> Sonstiges</a></li>
			       </ul>
			    </div>
		  	</div>
		@endif

		@if ($currentUser->hasRole('Admin') || $currentUser->can('generate_planning_mediumterm') || $currentUser->can('generate_planning_mediumterm_all'))
			<div class="btn-group">
				<a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#mediumtermplanning"><i class="glyphicon glyphicon-road"></i> Aus MLP generieren</a>
			</div>
		@endif

		@if ($currentUser->hasRole('Admin') || $currentUser->can('copy_planning') || $currentUser->can('copy_planning_all'))
			<div class="btn-group">
				{{HTML::decode(link_to_route('plannings.showall', '<i class="glyphicon glyphicon-repeat"></i> Einzelne LVs kopieren', array($display_turn->id) , array('class' => 'btn btn-xs btn-copy')))}}
			</div>

			@if ( $pastcourses > 0 )
			 	<div class="btn-group">
					<a href="#" class="btn btn-info btn-xs" data-toggle="modal" data-target="#copylastturn"><i class="glyphicon glyphicon-repeat"></i> {{$display_turn->name}} {{ ($display_turn->year-1) }} alle kopieren</a>
				</div>
			@endif
		@endif

		@if ($currentUser->hasRole('Admin') || $currentUser->can('change_planning_status'))
			<div class="btn-group">
				{{HTML::decode(link_to_route('plannings.statusOverview', '<i class="glyphicon glyphicon-refresh"></i> LV-Status aktualisieren', array($display_turn->id) , array('class' => 'btn btn-xs btn-primary')))}}
			</div>
		@endif
	</div>
</div>