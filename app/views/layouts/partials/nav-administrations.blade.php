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
            	<li><a href="{{ URL::to('researchgroups')}}">Arbeitsbereiche</a></li>
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
              	<li><a href="{{ URL::to('modules')}}">Module</a></li>
            @endif

            @if (Entrust::hasRole('Admin') || Entrust::can('edit_room'))
            	<li><a href="{{ URL::to('rooms')}}">Räume</a></li>
            @endif

            @if (Entrust::hasRole('Admin') || Entrust::can('edit_roomtype'))
                <li><a href="{{ URL::to('roomtypes')}}">Raumtypen</a></li>
            @endif

            @if (Entrust::hasRole('Admin') || Entrust::can('edit_turn'))
                <li><a href="{{ URL::to('turns')}}">Semester</a></li>
            @endif

            @if (Entrust::hasRole('Admin') || Entrust::can('edit_degreecourse'))
              	<li>{{ link_to_route('showDegreecourses_path', 'Studiengänge') }}</li>
            @endif

            @if (Entrust::hasRole('Admin') || Entrust::can('edit_section'))
                <li><a href="{{ URL::to('sections')}}">Studiengangsbereiche</a></li>
            @endif

            @if (Entrust::hasRole('Admin') || Entrust::can('edit_rotation'))
                <li><a href="{{ URL::to('rotations')}}">Turnus</a></li>
            @endif

            @if (Entrust::hasRole('Admin') || Entrust::can('edit_coursetype'))
                <li>{{ link_to_route('showCoursetypes_path', 'Veranstaltungsformen') }}</li>
            @endif

            @if (Entrust::hasRole('Admin') || Entrust::can('edit_user'))
            	<li class="divider"></li>
                <li class="dropdown-header">Zugriffsmanagement</li>
                <li><a href="{{ URL::to('users')}}">Benutzer</a></li>
            @endif

            @if (Entrust::hasRole('Admin') || Entrust::can('edit_role'))
                <li><a href="{{ URL::to('roles')}}">Rollen</a></li>
            @endif

            @if (Entrust::hasRole('Admin') || Entrust::can('edit_permission'))
                <li><a href="{{ URL::to('permissions')}}">Berechtigungen</a></li>
            @endif
           
      	</ul>
	</li>
@endif