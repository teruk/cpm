@section('scripts')
	@include('layouts.partials.calendar-script', ['weekends' => 'false'])
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
		<li class="active">Semesterplanung</li>
	    <li class="active">Übersicht Wochenplan</li>
		<li class="active">{{ $display_turn->name }} {{ $display_turn->year }}</li>
	</ol>
@stop

@section('main')
	<h4>Semesterplanung {{ $display_turn->name }} {{ $display_turn->year }} - Wochenplanansicht</h4>
	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">
			<!-- <h4>Semesterplanung - {{ $display_turn->name }} {{ $display_turn->year }}
		    <button class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModal">
			  	<span class="glyphicon glyphicon-question-sign"></span>
			</button>
			</h4>	 -->
			@include('layouts.partials.nav-turn-selection', ['route' => 'plannings.showSchedule'])
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div id='calendar'></div>
		</div>
	</div>
@stop