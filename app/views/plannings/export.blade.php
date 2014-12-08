@section('scripts')
	<link rel="stylesheet" type="text/css" href="{{ url('css/dataTables.bootstrap.css')}}">
	<script type="text/javascript" language="javascript" src="{{ url('js/jquery.dataTables.min.js')}}"></script>
	<script type="text/javascript" language="javascript" src="{{ url('js/dataTables.bootstrap.js')}}"></script>
	
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li class="active">Semesterplanung</li>
	</ol>
@stop

@section('main')
	@foreach ($plannings as $planning)
		['turn_id' => {{ $planning->turn_id }}, 'course_id' => {{ $planning->course_id }},'group_number' => {{ $planning->group_number }}, 'researchgroup_status' => {{ $planning->researchgroup_status }}, 'board_status' => {{ $planning->board_status }}, 'language' => {{ $planning->language}}, 'comment' => '{{ $planning->comment}}', 'course_number' => '{{ $planning->course_number }}', 'course_title' => '{{ $planning->course_title }}', 'course_title_eng' => '{{ $planning->course_title_eng }}', 'semester_periods_per_week' => {{ $planning->semester_periods_per_week }}, 'user_id' => {{ $planning->user_id }}, 'teaching_assignment' => {{ $planning->teaching_assignment }}, 'room_preference' => '{{ $planning->room_preference }}', 'created_at' => new DateTime, 'updated_at' => new DateTime],<br>
	@endforeach
	<br><br>
	@foreach ($employee_planning as $ep)
		['planning_id' => {{ $ep->planning_id }}, 'employee_id' => {{ $ep->planning_id }},'semester_periods_per_week' => {{ $ep->semester_periods_per_week }},  'created_at' => new DateTime, 'updated_at' => new DateTime],<br>
	@endforeach
	<br><br>
	@foreach ($planning_room as $pr)
		['planning_id' => {{ $pr->planning_id }}, 'room_id' => {{ $pr->room_id }},'weekday' => {{ $pr->weekday }}, 'start_time' => '{{ $pr->start_time }}', 'end_time' => '{{ $pr->end_time }}', 'created_at' => new DateTime, 'updated_at' => new DateTime],<br>
	@endforeach
	<br><br>
	@foreach ($module_turn as $mt)
		['module_id' => {{ $mt->module_id}}, 'turn_id' => {{ $mt->turn_id }}, 'exam' => {{ $mt->exam }}, 'created_at' => new DateTime, 'updated_at' => new DateTime],<br>
	@endforeach
	<br><br>
	@foreach ($planninglogs as $plog)
		['planning_id' => {{ $plog->planning_id}}, 'turn_id' => {{ $plog->turn_id}}, 'action' => '{{ $plog->action }}', 'category' => {{ $plog->category}}, 'action_type' => {{$plog->action_type}}, 'username' => '{{ $plog->username }}', 'created_at' => '{{ $plog->created_at }}', 'updated_at' => '{{ $plog->updated_at}}' ],<br>
	@endforeach
@stop