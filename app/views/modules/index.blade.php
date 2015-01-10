@extends('layouts.main')

@section('scripts')
	@include('layouts.partials.datatables-script')
	<script type="text/javascript" class="init">

    $(document).ready(function() {
    	$('#module_table').dataTable({
    		"pagingType": "full",
    		"displayLength": 50,
    		"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Alle"]]
    	});

      $('div.dataTables_filter input').focus()
    } );
	</script>

  @include('layouts.partials.delete-confirm-js')
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li class="active">Modulmanagement</li>
	</ol>
@stop

@section('main')

  @if (Entrust::hasRole('Admin') || Entrust::can('add_module'))
    @include('layouts.partials.add-button-modal',['buttonLabel' => 'Modul hinzufügen'])
  @endif
	        	
  <div class="row">
    <div class="col-sm-12" style="margin-bottom: 5px;">
    	<div  class="table-responsive">
       	<table class="table table-striped  table-condensed" id="module_table" cellspacing="0" width="100%">
       		<thead>
       			<tr>
       				<th>Kurz</th>
       				<th>Titel</th>
       				<th>Niveau</th>
       				<th>
                <span data-toggle="tooltip" data-placement="top" data-original-title="Anzahl der Leistungspunkt">LP</span>
              </th>
       				<th>Turnus</th>
       				<th>Abschluss</th>
       				<th>Sprache</th>
       				<th>Fachbereich</th>
              <th>
                <span data-toggle="tooltip" data-placement="top" data-original-title="Modul besteht aus individuellen Lehrveranstaltungen">IV</span>
                </th>
       				<th>Option</th>
       			</tr>
       		</thead>
       		<tbody>
    				@foreach( $modules as $module )
    					<tr>
      					<td>{{ $module->short }}</td>
      					<td>
                  @if (Entrust::hasRole('Admin') || Entrust::can('edit_module'))
                    {{ link_to_route('editModuleInformation_path', $module->name, $module->id) }}
                  @else
                    {{ $module->name }}
                  @endif
                </td>
      					<td>{{ $listofdegrees[$module->degree_id] }}</td>
      					<td>{{ $module->credits }}</td>
      					<td>{{ $listofrotations[$module->rotation_id] }}</td>
      					<td>{{ Config::get('constants.exam_type')[$module->exam_type] }} </td>
      					<td>{{ Config::get('constants.language')[$module->language] }}</td>
      					<td>{{ $listofdepartments[$module->department_id] }}</td>
                <td>
                  @if ($module->individual_courses)
                    ja
                  @else
                    nein
                  @endif
                </td>
      					<td>
      						@if (Entrust::hasRole('Admin') || Entrust::can('delete_module'))
                    {{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('deleteModule_path', $module->id))) }}
      						   {{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'button', 'class' => 'btn btn-xs btn-danger', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Modul löschen', 'data-message' => 'Wollen Sie das Modul wirklich löschen?')) }}
                    {{ Form::close() }}
                  @endif
      					</td>
    					</tr>
    				@endforeach	
    			</tbody>
    		</table>
    	</div>
    </div>
  </div>

  <!-- add form modal dialog -->
  @include('modules.partials.add-form')

  <!-- delete confirmation modal dialog -->
  @include('layouts.partials.delete_confirm')
@stop