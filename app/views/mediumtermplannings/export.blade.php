@section('scripts')
	<link rel="stylesheet" type="text/css" href="{{ url('css/dataTables.bootstrap.css')}}">
	<script type="text/javascript" language="javascript" src="{{ url('js/jquery-1.10.2.min.js')}}"></script>
	<script type="text/javascript" language="javascript" src="{{ url('js/jquery.dataTables.min.js')}}"></script>
	<script type="text/javascript" language="javascript" src="{{ url('js/dataTables.bootstrap.js')}}"></script>

@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li class="active">Mittelfriste Lehrplanung</li>
	</ol>
@stop

@section('main')
	@foreach ($mediumtermplannings as $mtp)
		['module_id' => {{ $mtp->module_id }}, 'turn_id' => {{ $mtp->turn_id }}, 'created_at' => new DateTime, 'updated_at' => new DateTime],<br>
	@endforeach
	
	@foreach ($employee_mediumtermplanning as $em)
		['mediumtermplanning_id' => {{ $em->mediumtermplanning_id }}, 'employee_id' => {{ $em->employee_id }}, 'semester_periods_per_week' => {{ $em->semester_periods_per_week }}, 'annulled' => {{ $em->annulled }}, 'created_at' => new DateTime, 'updated_at' => new DateTime],<br>
	@endforeach
@stop