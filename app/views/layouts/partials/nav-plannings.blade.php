@if (Entrust::hasRole('Admin') || Entrust::can('view_planning') || $currentUser->researchgroups->count() > 0)
	<li class="dropdown">
  		<a href="{{ URL::to('/')}}" class="dropdown-toggle" data-toggle="dropdown">Semesterplanung <b class="caret"></b></a>
  		
      	<ul class="dropdown-menu">
			<li>{{ link_to_route('plannings.index', 'Planungen verwalten') }}</li>

			@if (Entrust::hasRole('Admin') || $currentUser->researchgroups->count() > 0)
				<li>{{ link_to_route('plannings.showSchedule', 'Übersicht Wochenplan', $currentTurn) }}</li>
			@endif

			@if (Entrust::hasRole('Admin') || Entrust::can('view_room_preferences'))
				<li>{{ link_to_route('plannings.showRoomPreference', 'Übersicht Raumwünsche', $currentTurn) }}</li>
			@endif
		</ul>
	</li>
@endif