@section('scripts')
	@include('layouts.partials.calendar-script', ['weekends' => 'false'])
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
		<li class="active">Semesterplanung</li>
	    <li class="active">Übersicht Wochenplan</li>
		<li class="active">{{ $turnNav['displayTurn']->name }} {{ $turnNav['displayTurn']->year }}</li>
	</ol>
@stop

@section('main')
	<h4>Semesterplanung {{ $turnNav['displayTurn']->name }} {{ $turnNav['displayTurn']->year }} - Wochenplanansicht</h4>
	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">
			@include('layouts.partials.nav-turn-selection', ['route' => 'plannings.showSchedule'])
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div id='calendar'></div>
		</div>
	</div>
@stop