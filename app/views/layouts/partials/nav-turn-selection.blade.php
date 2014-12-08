<div class="btn-group btn-group-justified">
	<div class="btn-group">
		<a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    	Ältere Semester
    	<span class="caret"></span>
  		</a>
        <ul class="dropdown-menu">
        	@foreach ($before_turns as $turn)
	        	<li><a href="{{ route($route, $turn->id) }}">{{$turn->name}} {{$turn->year}}</a></li>
	        @endforeach
        </ul>
	</div>
	@if (sizeof($current_turn) > 0)
		<a href="{{ route($route, $current_turn->id) }}" class="btn btn-default">{{$current_turn->name}} {{$current_turn->year}}</a>
	@endif
	@if (sizeof($next_turn) > 0)
		<a href="{{ route($route, $next_turn->id) }}" class="btn btn-default">{{$next_turn->name}} {{$next_turn->year}}</a>
	@endif
	@if (sizeof($afternext_turn) > 0)
		<a href="{{ route($route, $afternext_turn->id) }}" class="btn btn-default">{{$afternext_turn->name}} {{$afternext_turn->year}}</a>
	@endif
	
</div>