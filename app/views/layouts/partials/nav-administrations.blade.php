@if ($currentUser->roles->count() > 0)
    <li class="dropdown">
  		<a href="{{ URL::to('/')}}" class="dropdown-toggle" data-toggle="dropdown">Administration <b class="caret"></b></a>
      	<ul class="dropdown-menu">
      		<li class="dropdown-header">Lehrplanung</li>
      		@if (Entrust::hasRole('Admin') || Entrust::can('edit_announcement'))
                <li>{{ link_to_route('showAnnouncements_path', 'Ankündigungen') }}</li>
            @endif

            @if (Entrust::hasRole('Admin') || Entrust::can('edit_appointedday'))
                <li>{{ link_to_route('showAppointeddays_path', 'Termine') }}</li>
            @endif

            @if (Entrust::hasRole('Admin') || Entrust::can('view_settings'))
                <li>{{ link_to_route('showSettings_path', 'Einstellungen') }}</li>
            @endif

            <li class="divider"></li>
            <li class="dropdown-header">Management</li>

            @if (Entrust::hasRole('Admin') || Entrust::can('edit_degree'))
                <li>{{ link_to_route('showDegrees_path', 'Abschlüsse') }}</li>
            @endif

            @if (Entrust::hasRole('Admin') || Entrust::can('edit_researchgroup'))
            	<li>{{ link_to_route('showResearchgroups_path', 'Arbeitsbereiche') }}</li>
            @endif

            @if (Entrust::hasRole('Admin'))
            	<li>{{ link_to_route('showDepartments_path', 'Fachbereiche') }}</li>
            @endif

            @if (Entrust::hasRole('Admin') || Entrust::can('edit_course'))
              	<li>{{ link_to_route('showCourses_path', 'Lehrveranstaltungen') }}</li>
            @endif

            @if (Entrust::hasRole('Admin') || Entrust::can('edit_employee'))
            	<li>{{ link_to_route('showEmployees_path', 'Mitarbeiter') }}</li>
            @endif

            @if (Entrust::hasRole('Admin') || Entrust::can('edit_module'))
              	<li>{{ link_to_route('showModules_path', 'Module') }}</li>
            @endif

            @if (Entrust::hasRole('Admin') || Entrust::can('edit_room'))
            	<li>{{ link_to_route('showRooms_path', 'Räume') }}</li>
            @endif

            @if (Entrust::hasRole('Admin') || Entrust::can('edit_roomtype'))
                <li>{{ link_to_route('showRoomtypes_path', 'Raumtypen') }}</li>
            @endif

            @if (Entrust::hasRole('Admin') || Entrust::can('edit_turn'))
                <li>{{ link_to_route('showTurns_path', 'Semester') }}</li>
            @endif

            @if (Entrust::hasRole('Admin') || Entrust::can('edit_degreecourse'))
              	<li>{{ link_to_route('showDegreecourses_path', 'Studiengänge') }}</li>
            @endif

            @if (Entrust::hasRole('Admin') || Entrust::can('edit_section'))
                <li>{{ link_to_route('showSections_path', 'Studiengangsbereiche') }}</li>
            @endif

            @if (Entrust::hasRole('Admin') || Entrust::can('edit_rotation'))
                <li>{{ link_to_route('showRotations_path', 'Turnus') }}</li>
            @endif

            @if (Entrust::hasRole('Admin') || Entrust::can('edit_coursetype'))
                <li>{{ link_to_route('showCoursetypes_path', 'Veranstaltungsformen') }}</li>
            @endif

            @if (Entrust::hasRole('Admin') || Entrust::can('edit_user'))
            	<li class="divider"></li>
                <li class="dropdown-header">Zugriffsmanagement</li>
                <li>{{ link_to_route('showUsers_path', 'Benutzer') }}</li>
            @endif

            @if (Entrust::hasRole('Admin') || Entrust::can('edit_role'))
                <li>{{ link_to_route('showRoles_path', 'Rollen') }}</li>
            @endif

            @if (Entrust::hasRole('Admin') || Entrust::can('edit_permission'))
                <li>{{ link_to_route('showPermissions_path', 'Berechtigungen') }}</li>
            @endif
           
      	</ul>
	</li>
@endif