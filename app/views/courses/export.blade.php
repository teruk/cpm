@section('scripts')
	<link rel="stylesheet" type="text/css" href="{{ url('css/dataTables.bootstrap.css')}}">
	<script type="text/javascript" language="javascript" src="{{ url('js/jquery-1.10.2.min.js')}}"></script>
	<script type="text/javascript" language="javascript" src="{{ url('js/jquery.dataTables.min.js')}}"></script>
	<script type="text/javascript" language="javascript" src="{{ url('js/dataTables.bootstrap.js')}}"></script>
	
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li class="active">Lehrveranstaltungsmanagement</li>
	</ol>
@stop

@section('main')
	@foreach ($courses as $course)
		['name' => '{{$course->name}}', 'name_eng' => '{{$course->name_eng}}', 'course_number' => '{{$course->course_number}}', 'course_type_id' => {{$course->course_type_id}}, 'module_id' => {{$course->module_id}}, 'participants' => {{$course->participants}}, 'language' => {{$course->language}}, 'semester_periods_per_week' => {{$course->semester_periods_per_week}}, 'department_id' => 1],<br>
	@endforeach
@stop