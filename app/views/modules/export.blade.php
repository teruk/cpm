@section('scripts')
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li class="active">Modulmanagement</li>
	</ol>
@stop

@section('main')
	@foreach($modules as $module)
		['name' => '{{$module->name}}', 'short' => '{{$module->short}}',	'name_eng' => '{{$module->name_eng}}', 'exam_type' => {{$module->exam_type}}, 'credits' => {{$module->credits}}, 'department_id' => {{$module->department_id}}, 'rotation_id' => {{$module->rotation_id}}, 'language' => {{$module->language}}, 'degree_id' => {{$module->degree_id}}, 'individual_courses' => {{ $module->individual_courses}}, 'created_at' =>  new DateTime, 'updated_at' => new DateTime],<br>
	@endforeach
	<br><br>
	@foreach($dgm as $d)
		['degree_course_id' => {{$d->degree_course_id}}, 'module_id' => {{$d->module_id}}, 'semester' => {{$d->semester}}, 'section' => {{$d->section}}, 'created_at' =>  new DateTime, 'updated_at' => new DateTime],<br>
	@endforeach
@stop