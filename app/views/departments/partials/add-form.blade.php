<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Neuen Fachbereich anlegen</h4>
      </div>
      <div class="modal-body">
        {{ Form::model(new Department, ['route' => ['saveDepartment_path']])}}
        <table class="table table-striped">
			<tbody>
				<tr>
					<td>{{ Form::label('short', 'Kürzel*:') }}</td>
					<td align="right">{{ Form::text('short', '', array('size' => 40)) }}</td>
				</tr>
				<tr>
					<td>{{ Form::label('name', 'Name*:') }}</td>
					<td align="right">{{ Form::text('name', '', array('size' => 40)) }}</td>	
				</tr>
				<tr>
					<td>*erforderlich</td>
					<td align="right">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Abbrechen</button>
						{{ Form::submit('Erstellen', array('class' => 'btn btn btn-success')) }}
					</td>
				</tr>
			</tbody>
		</table>
		{{ Form::close() }}
      </div>
    </div>
  </div>
</div>