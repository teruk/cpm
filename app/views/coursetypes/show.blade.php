@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li>{{ link_to_route('showCoursetypes_path', 'Kurstypmanagement') }}</li>
	  <li class="active">{{ $coursetype->name }}</li>
	</ol>
@stop

@section('main')
	<h3>{{ $coursetype->name }}</h3>
	
	<div class="row">
		<div class="col-sm-7">
			<div class="panel panel-primary">
		       	<div class="panel-heading">
			        <h3 class="panel-title">Informationen</h3>
		        </div>
		        <div class="panel-body">
					{{ Form::model($coursetype, ['method' => 'PATCH', 'route' => ['updateCoursetype_path', $coursetype->id]]) }}
					<table class="table table-striped">
						<tbody>
							<tr>
								<td>{{ Form::label('name', 'Name*:') }}</td>
								<td align="right">{{ Form::input('text', 'name', $coursetype->name, array('id' => "name", 'min' => 3, 'required' => true, 'class' => "form-control input-sm")) }}</td>	
							</tr>	
							<tr>
								<td>{{ Form::label('short', 'Kurz*:') }}</td>
								<td align="right">{{ Form::input('text', 'short', $coursetype->short, array('id' => "short", 'min' => 3, 'required' => true, 'class' => "form-control input-sm")) }}</td>	
							</tr>
							<tr>
								<td>{{ Form::label('description', 'Beschreibung:') }}</td>
								<td align="right">{{ Form::textarea('description', $coursetype->description, array('id' => "description", 'class' => "form-control input-sm", 'rows'=>2, 'style' => 'resize:none;')) }}</td>	
							</tr>						 
							<tr>
								<td >* erforderlich</td>
								<td align="right">{{ Form::button('<i class="glyphicon glyphicon-refresh"></i> Aktualisieren', array('type' => 'submit', 'class' => 'btn btn-sm btn-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Informationen aktualisieren')) }}</td>
							</tr>
						</tbody>
					</table>
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
@stop