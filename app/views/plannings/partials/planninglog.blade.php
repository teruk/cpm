<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-primary">
            <div class="panel-body">
            	<h5>Änderungsprotokoll:</h5>
            	<table class="table table-striped table-condensed">
            		<thead>
            			<tr>
            				<th>Datum</th>
            				<th>Kategorie</th>
            				<th>Benutzer</th>
            				<th>Änderung</th>
            			</tr>
            		</thead>
            		<tbody>
            			@foreach($planninglog as $pl)
            				@if ($pl->action_type == 0)
                                <tr class='success'>
                            @endif
                            @if ($pl->action_type == 1)
                                <tr class='info'>
                            @endif
                            @if ($pl->action_type == 2)
                                <tr class='danger'>
                            @endif
            					<td>{{ date('d.m.Y - H:i', strtotime($pl->created_at))  }}</td>
            					<td>{{ Config::get('constants.planninglog_category')[$pl->category] }}</td>
            					<td>{{ $pl->username }}</td>
            					<td>{{ $pl->action }}</td>
            				</tr>
		            	@endforeach
            		</tbody>
            	</table>
            	
            </div>
        </div>
    </div>
</div>