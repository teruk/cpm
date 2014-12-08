@section('scripts')
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li class="active">Modulmanagement</li>
	</ol>
@stop

@section('main')
	@foreach($employees as $employee)
		['name' => '{{$employee->name}}', 'firstname' => '{{$employee->firstname}}', 'title' => '{{$employee->title}}', 'researchgroup_id' => '{{ $employee->researchgroup_id}}', 'teaching_load' => {{ $employee->teaching_load }}, 'employed_since' => {{$employee->employed_since}}, 'employed_till' => {{ $employee->employed_till }} ],<br>
	@endforeach
@stop