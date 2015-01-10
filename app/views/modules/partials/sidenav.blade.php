<div class="col-md-3" style="border: 1px; border-style: rounded;">

	<ul class="list-unstyled">
		<li><b>Optionen:</b></li>
	</ul>
	<div class="btn-group-vertical">
		{{ link_to_route('editModuleInformation_path', 'Informationen bearbeiten', [$module->id], ['class' => 'btn btn-default']) }}
		{{ link_to_route('showModuleCourses_path', 'Zugehörige Lehrveranstaltungen', [$module->id], ['class' => 'btn btn-default']) }}
		{{ link_to_route('showModuleDegreecourses_path', 'Zugeordnete Studiengänge', [$module->id], ['class' => 'btn btn-default']) }}
		{{ link_to_route('showModuleMediumtermplannings_path', 'Mittelfristige Lehrplanung', [$module->id], ['class' => 'btn btn-default']) }}
	</div>

	<ul class="list-unstyled">
		<li>{{ link_to_route('showModules_path', 'Zurück zur Übersicht', null, ['class' => 'btn btn-sm btn-link']) }}</li>
	</ul>
</div>