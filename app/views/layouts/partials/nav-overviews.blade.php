<li class="dropdown">
  	<a href="{{ URL::to('/')}}" class="dropdown-toggle" data-toggle="dropdown">Übersichten<b class="caret"></b></a>
  	<ul class="dropdown-menu">

  		<li>{{ link_to_route('showPlanningsOrderByResearchgroup_path', 'AB-Aufstellung Veranstaltungen', $currentTurn) }}</li>
  		<li>{{ link_to_route('showPlanningsOrderByCourseNumber_path', 'Aufstellung Veranstaltungen', $currentTurn) }}</li>
    	<li>{{ link_to_route('showMediumTermPlannings_path', 'Mittelfristge Lehrplanung') }}</li>
    	<li>{{ link_to_route('showExams_path', 'Prüfungen', $currentTurn) }}</li>
    	<li>{{ link_to_route('overview.default_room', 'Raumbelegung') }}</li>
    	<li>{{ link_to_route('showRoomSearchForm_path', 'Raumsuche') }}</li>
    	<li>{{ link_to_route('overview.default_schedule', 'Stundenpläne') }}</li>
    	<li>{{ link_to_route('showStudentAssistants_path', 'SHK-Übersicht', $currentTurn) }}</li>
    	<li class="divider"></li>

      <li class="dropdown-header">Details</li>
      <li>{{ link_to_route('showOverviewCourses_path', 'Lehrveranstaltungen') }}</li>
      <li>{{ link_to_route('showOverviewEmployees_path', 'Mitarbeiter') }}</li>
      <li>{{ link_to_route('showOverviewModules_path', 'Module') }}</li>
      <li>{{ link_to_route('showOverviewDegreecourses_path', 'Studiengänge') }}</li>

  	</ul>
</li>