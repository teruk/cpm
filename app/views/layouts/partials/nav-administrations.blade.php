@if ($currentUser->roles->count() > 0)
    <li class="dropdown">
  		<a href="{{ URL::to('/')}}" class="dropdown-toggle" data-toggle="dropdown">Administration <b class="caret"></b></a>
      	<ul class="dropdown-menu">
      		<li class="dropdown-header">Lehrplanung</li>
      		@if (Entrust::hasRole('Admin') || Entrust::can('edit_announcement'))
                <li><a href="{{ URL::to('announcements')}}">Ankündigungen</a></li>
            @endif
            @if (Entrust::hasRole('Admin') || Entrust::can('edit_appointedday'))
                <li><a href="{{ URL::to('appointeddays')}}">Termine</a></li>
            @endif
            @if (Entrust::hasRole('Admin') || Entrust::can('view_settings'))
                <li><a href="{{ URL::to('settings')}}">Einstellungen</a></li>
            @endif
            <li class="divider"></li>
            <li class="dropdown-header">Management</li>
            @if (Entrust::hasRole('Admin') || Entrust::can('edit_degree'))
                <li><a href="{{ URL::to('degrees')}}">Abschlüsse</a></li>
            @endif
            @if (Entrust::hasRole('Admin') || Entrust::can('edit_researchgroup'))
            	<li><a href="{{ URL::to('researchgroups')}}">Arbeitsbereiche</a></li>
            @endif
            @if (Entrust::hasRole('Admin'))
            	<li><a href="{{ URL::to('departments')}}">Fachbereiche</a></li>
            @endif
            @if (Entrust::hasRole('Admin') || Entrust::can('edit_course'))
              	<li><a href="{{ URL::to('courses')}}">Lehrveranstaltungen</a></li>
            @endif
            @if (Entrust::hasRole('Admin') || Entrust::can('edit_employee'))
            	<li><a href="{{ URL::to('employees')}}">Mitarbeiter</a></li>
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
              	<li><a href="{{ URL::to('degree_courses')}}">Studiengänge</a></li>
            @endif
            @if (Entrust::hasRole('Admin') || Entrust::can('edit_section'))
                <li><a href="{{ URL::to('sections')}}">Studiengangsbereiche</a></li>
            @endif
            @if (Entrust::hasRole('Admin') || Entrust::can('edit_rotation'))
                <li><a href="{{ URL::to('rotations')}}">Turnus</a></li>
            @endif
            @if (Entrust::hasRole('Admin') || Entrust::can('edit_coursetype'))
                <li><a href="{{ URL::to('coursetypes')}}">Veranstaltungsformen</a></li>
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