<div class="btn-group btn-group-justified">
	<div class="btn-group">
		<a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    	Ältere Semester
    	<span class="caret"></span>
  		</a>
        <ul class="dropdown-menu">
        	@foreach ($turnNav['beforeTurns'] as $turn)
	        	<li><a href="{{ route($route, $turn->id) }}">{{$turn->name}} {{$turn->year}}</a></li>
	        @endforeach
        </ul>
	</div>
	@if (sizeof($turnNav['currentTurn']) > 0)
		<a href="{{ route($route, $turnNav['currentTurn']->id) }}" class="btn btn-default">{{$turnNav['currentTurn']->name}} {{$turnNav['currentTurn']->year}}</a>
	@endif
	@if (sizeof($turnNav['nextTurn']) > 0)
		<a href="{{ route($route, $turnNav['nextTurn']->id) }}" class="btn btn-default">{{$turnNav['nextTurn']->name}} {{$turnNav['nextTurn']->year}}</a>
	@endif
	@if (sizeof($turnNav['afterNextTurn']) > 0)
		<a href="{{ route($route, $turnNav['afterNextTurn']->id) }}" class="btn btn-default">{{$turnNav['afterNextTurn']->name}} {{$turnNav['afterNextTurn']->year}}</a>
	@endif
	
</div>