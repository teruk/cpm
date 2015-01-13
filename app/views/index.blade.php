@extends('layouts.main')

@section('main')
    <div class="row">
    	<h3>Willkommen beim Lehrplanungsmanagement-Prototyp</h3>

    	<article>
			Dieser Prototyp soll den Lehrplanungsprozess des Fachbereichs Informatik der Universität Hamburg unterstützen. Es soll der gesamte Prozess unterstützt werden, beginnend bei der Prognose des Lehrbedarfs über die Erfassung und Auswertung der Lehrangebote der einzelnen Arbeitsbereiche bis hin zu Raum- und Zeitplanung. Das Ziel welches mit dem Prototypen verfolgt wird, ist die kooperativere und transparentere Gestaltung des Lehrplanungsprozesses sowie die Minimierung von potenziellen Fehlerquellen (z.B. Übertragung der Lehrangbote aus unterschiedlichen Medien in die Datenbank).
		</article>

		<h5>Folgende Funktionen enthält der aktuelle Prototyp:</h5>
		<ul>
			<li>
				Stammdatenmanagement:
				<ul>
					<li>Verwaltung von Studiengängen</li>
					<li>Verwaltung von Modulen und Lehrveranstaltungen, Zuordnung zu Studiengängen</li>
					<li>Verwaltung von Arbeitsbereichen und Mitarbeitern</li>
				</ul>
			</li>
			<li>Mittelfristige Lehrplanung</li>
			<li>
				Semesterplanung:
				<ul>
					<li>Generierung der Planung aus der Mittelfristigen Lehrplanung</li>
					<li>Kopieren einen oder mehrere Lehrveranstaltungen aus vergangenen Semestern</li>
					<li>Kopieren eines kompletten Semesters</li>
					<li>Planung einzelner Lehrveranstaltungen oder ganzer Module</li>
					<li>Zuordnung von Lehrenden und Räumen zu Planungen</li>
					<li>Ermittlung von Raum- und Zeitkonflikten</li>
				</ul>
			</li>
			<li>
				Weitere Funktionen:
				<ul>
					<li>Suche nach freien Räumen</li>
					<li>Generierung von Studenplänen für einzelne Studiengänge nach Fachsemester</li>
					<li>Generierung von Raumbelegungsplänen</li>
					<li>Verschiedene Übersichten, wie z.B. Veranstaltungsaufstellung sortiert nach Arbeitsbereich, {{ link_to_route('showStudentAssistants_path', 'SHK-Übersicht', $currentTurn->id) }}</li>
				</ul>
			</li>
		</ul>

		<h5>Angestrebte Funktionen:</h5>
		<ul>
			<li></li>
		</ul>
    </div>
@stop