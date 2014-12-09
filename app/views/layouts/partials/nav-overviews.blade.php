<li class="dropdown">
  	<a href="{{ URL::to('/')}}" class="dropdown-toggle" data-toggle="dropdown">Übersichten<b class="caret"></b></a>
  	<ul class="dropdown-menu">
  		<li>{{ link_to_route('overview.tableRG', 'AB-Aufstellung Veranstaltungen') }}</li>
  		<li>{{ link_to_route('overview.tablePl', 'Aufstellung Veranstaltungen') }}</li>
      	<li>{{ link_to_route('mediumtermsplannings.index', 'Mittelfristge Lehrplanung') }}</li>
      	<li>{{ link_to_route('overview.exams', 'Prüfungen') }}</li>
      	<li>{{ link_to_route('overview.default_room', 'Raumbelegung') }}</li>
      	<li>{{ link_to_route('overview.showRoomSearch', 'Raumsuche') }}</li>
      	<li>{{ link_to_route('overview.default_schedule', 'Stundenpläne') }}</li>
      	<li>{{ link_to_route('overview.shk', 'SHK-Übersicht') }}</li>
      	<li class="divider"></li>
        <li class="dropdown-header">Details</li>
        <li>{{ link_to_route('overview.courses', 'Lehrveranstaltungen') }}</li>
        <li>{{ link_to_route('overview.employees', 'Mitarbeiter') }}</li>
        <li>{{ link_to_route('overview.modules', 'Module') }}</li>
        <li>{{ link_to_route('overview.degreecourses', 'Studiengänge') }}</li>
  	</ul>
</li>